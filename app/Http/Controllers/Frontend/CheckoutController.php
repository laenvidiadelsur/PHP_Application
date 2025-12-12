<?php

namespace App\Http\Controllers\Frontend;

use App\Domain\Lta\Models\Carrito;
use App\Domain\Lta\Models\CarritoItem;
use App\Domain\Lta\Models\Orden;
use App\Domain\Lta\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        // Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para realizar una compra');
        }
        
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('products.index')
                ->with('error', 'Tu carrito está vacío');
        }
        
        // Validar productos del carrito
        $subtotal = 0;
        $items = [];
        $errors = [];
        
        foreach ($cart as $productId => $item) {
            $producto = Producto::find($productId);
            
            if (!$producto) {
                $errors[] = "El producto con ID {$productId} ya no existe";
                unset($cart[$productId]);
                continue;
            }
            
            // Validar que el producto esté activo
            if ($producto->estado !== 'activo') {
                $errors[] = "El producto '{$producto->name}' no está disponible";
                unset($cart[$productId]);
                continue;
            }
            
            // Validar stock
            if ($producto->stock < $item['quantity']) {
                $errors[] = "No hay suficiente stock para '{$producto->name}'. Stock disponible: {$producto->stock}";
                // Ajustar cantidad al stock disponible
                if ($producto->stock > 0) {
                    $item['quantity'] = $producto->stock;
                    $cart[$productId]['quantity'] = $producto->stock;
                } else {
                    unset($cart[$productId]);
                    continue;
                }
            }
            
            // Validar cantidad mínima
            if ($item['quantity'] <= 0) {
                unset($cart[$productId]);
                continue;
            }
            
            // Recalcular precio desde BD (por si cambió)
            $itemPrice = $producto->price;
            $itemTotal = $itemPrice * $item['quantity'];
            $subtotal += $itemTotal;
            
            $items[] = [
                'id' => $productId,
                'producto' => $producto,
                'quantity' => $item['quantity'],
                'price' => $itemPrice,
                'total' => $itemTotal,
            ];
        }
        
        // Actualizar carrito si hubo cambios
        if (!empty($errors) || count($cart) !== count(Session::get('cart', []))) {
            Session::put('cart', $cart);
            if (!empty($errors)) {
                Session::flash('warning', implode('<br>', $errors));
            }
        }
        
        // Si no quedan items, redirigir
        if (empty($items)) {
            Session::forget('cart');
            return redirect()->route('products.index')
                ->with('error', 'No hay productos válidos en tu carrito');
        }
        
        $tax = $subtotal * 0.15; // 15% de impuesto
        $total = $subtotal + $tax;
        
        return view('frontend.checkout.index', [
            'pageTitle' => 'Checkout',
            'items' => $items,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);
    }
    
    public function process(Request $request)
    {
        // Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión para realizar una compra');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|string|in:card,transfer,cash',
        ]);
        
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('products.index')
                ->with('error', 'Tu carrito está vacío');
        }
        
        try {
            DB::beginTransaction();
            
            // Validar y preparar productos
            $subtotal = 0;
            $supplierId = null;
            $productosToUpdate = [];
            $errors = [];
            
            foreach ($cart as $productId => $item) {
                $producto = Producto::lockForUpdate()->find($productId);
                
                if (!$producto) {
                    $errors[] = "El producto con ID {$productId} ya no existe";
                    continue;
                }
                
                // Validar que el producto esté activo
                if ($producto->estado !== 'activo') {
                    $errors[] = "El producto '{$producto->name}' no está disponible";
                    continue;
                }
                
                // Validar stock disponible
                if ($producto->stock < $item['quantity']) {
                    $errors[] = "No hay suficiente stock para '{$producto->name}'. Stock disponible: {$producto->stock}, solicitado: {$item['quantity']}";
                    continue;
                }
                
                // Validar cantidad mínima
                if ($item['quantity'] <= 0) {
                    $errors[] = "La cantidad para '{$producto->name}' debe ser mayor a 0";
                    continue;
                }
                
                // Calcular subtotal con precio actual de BD
                $itemTotal = $producto->price * $item['quantity'];
                $subtotal += $itemTotal;
                
                // Guardar para actualizar stock después
                $productosToUpdate[] = [
                    'producto' => $producto,
                    'quantity' => $item['quantity'],
                ];
                
                // Obtener supplier del primer producto
                if ($supplierId === null) {
                    $supplierId = $producto->supplier_id;
                }
            }
            
            // Si hay errores, cancelar transacción
            if (!empty($errors)) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->with('error', implode('<br>', $errors));
            }
            
            // Si no hay productos válidos
            if (empty($productosToUpdate)) {
                DB::rollBack();
                Session::forget('cart');
                return redirect()->route('products.index')
                    ->with('error', 'No hay productos válidos en tu carrito');
            }
            
            $tax = $subtotal * 0.15;
            $total = $subtotal + $tax;
            
            // Crear carrito en BD
            $carrito = Carrito::create([
                'user_id' => Auth::id(),
                'supplier_id' => $supplierId,
                'foundation_id' => null,
            ]);
            
            // Crear items del carrito y actualizar stock
            foreach ($productosToUpdate as $itemData) {
                $producto = $itemData['producto'];
                $quantity = $itemData['quantity'];
                
                // Crear item del carrito
                CarritoItem::create([
                    'cart_id' => $carrito->id,
                    'product_id' => $producto->id,
                    'quantity' => $quantity,
                ]);
                
                // Actualizar stock del producto
                $producto->stock -= $quantity;
                $producto->save();
            }
            
            // Crear orden
            $orden = Orden::create([
                'cart_id' => $carrito->id,
                'total_amount' => $total,
                'estado' => 'pendiente',
            ]);
            
            DB::commit();
            
            // Limpiar carrito de sesión
            Session::forget('cart');
            
            return redirect()->route('checkout.success', $orden)
                ->with('success', '¡Orden creada exitosamente!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Error en checkout: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'cart' => $cart,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al procesar la orden. Por favor, intenta nuevamente.');
        }
    }
    
    public function success(Orden $orden)
    {
        // Verificar que la orden pertenezca al usuario autenticado
        if ($orden->cart->user_id !== Auth::id() && !Auth::user()->can('access-admin')) {
            abort(403, 'No tienes permiso para ver esta orden');
        }
        
        $orden->load(['cart.items.product', 'cart.user']);
        
        return view('frontend.checkout.success', [
            'pageTitle' => 'Orden Confirmada',
            'orden' => $orden,
        ]);
    }
}
