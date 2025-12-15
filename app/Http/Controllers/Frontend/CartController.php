<?php

namespace App\Http\Controllers\Frontend;

use App\Domain\Lta\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request, Producto $producto)
    {
        // Validar que el producto esté activo
        if ($producto->estado !== 'activo') {
            return redirect()->back()
                ->with('error', 'Este producto no está disponible');
        }
        
        // Validar stock
        $quantity = $request->input('quantity', 1);
        if ($quantity <= 0) {
            return redirect()->back()
                ->with('error', 'La cantidad debe ser mayor a 0');
        }
        
        if ($producto->stock < $quantity) {
            return redirect()->back()
                ->with('error', "No hay suficiente stock. Stock disponible: {$producto->stock}");
        }
        
        $cart = Session::get('cart', []);
        
        // Si el producto ya está en el carrito, sumar cantidad
        if (isset($cart[$producto->id])) {
            $newQuantity = $cart[$producto->id]['quantity'] + $quantity;
            
            // Validar que la nueva cantidad no exceda el stock
            if ($producto->stock < $newQuantity) {
                return redirect()->back()
                    ->with('error', "No hay suficiente stock. Stock disponible: {$producto->stock}, ya tienes {$cart[$producto->id]['quantity']} en el carrito");
            }
            
            $cart[$producto->id]['quantity'] = $newQuantity;
        } else {
            $cart[$producto->id] = [
                "name" => $producto->name,
                "quantity" => $quantity,
                "price" => $producto->price,
                "image_url" => $producto->image_url ?? null,
                "supplier_id" => $producto->supplier_id,
            ];
        }
        
        Session::put('cart', $cart);
        
        return redirect()->back()
            ->with('success', 'Producto agregado al carrito exitosamente!');
    }

    public function index()
    {
        $cart = Session::get('cart', []);
        $items = [];
        $subtotal = 0;
        $errors = [];
        
        foreach ($cart as $productId => $item) {
            $producto = Producto::find($productId);
            
            if (!$producto) {
                $errors[] = "El producto con ID {$productId} ya no existe";
                unset($cart[$productId]);
                continue;
            }
            
            if ($producto->estado !== 'activo') {
                $errors[] = "El producto '{$producto->name}' no está disponible";
                unset($cart[$productId]);
                continue;
            }
            
            // Ajustar cantidad si excede stock
            if ($producto->stock < $item['quantity']) {
                if ($producto->stock > 0) {
                    $item['quantity'] = $producto->stock;
                    $cart[$productId]['quantity'] = $producto->stock;
                    $errors[] = "La cantidad de '{$producto->name}' se ajustó al stock disponible: {$producto->stock}";
                } else {
                    unset($cart[$productId]);
                    $errors[] = "El producto '{$producto->name}' está agotado";
                    continue;
                }
            }
            
            $itemTotal = $producto->price * $item['quantity'];
            $subtotal += $itemTotal;
            
            $items[] = [
                'id' => $productId,
                'producto' => $producto,
                'quantity' => $item['quantity'],
                'price' => $producto->price,
                'total' => $itemTotal,
            ];
        }
        
        // Actualizar carrito si hubo cambios
        if (count($cart) !== count(Session::get('cart', [])) || !empty($errors)) {
            Session::put('cart', $cart);
        }
        
        $tax = $subtotal * 0.15;
        $total = $subtotal + $tax;
        
        return view('frontend.cart.index', [
            'pageTitle' => 'Carrito de Compras',
            'items' => $items,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'errors' => $errors,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $productId = $request->id;
        $quantity = $request->quantity;
        
        $producto = Producto::find($productId);
        
        if (!$producto) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }
        
        if ($producto->estado !== 'activo') {
            return response()->json([
                'success' => false,
                'message' => 'El producto no está disponible'
            ], 400);
        }
        
        if ($producto->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => "No hay suficiente stock. Stock disponible: {$producto->stock}"
            ], 400);
        }
        
        $cart = session()->get('cart');
        
        if (isset($cart[$productId])) {
            $cart[$productId]["quantity"] = $quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Carrito actualizado exitosamente');
        }
        
        return response()->json(['success' => true]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);
        
        $productId = $request->id;
        $cart = session()->get('cart');
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            session()->flash('success', 'Producto eliminado exitosamente');
        }
        
        return response()->json(['success' => true]);
    }
}
