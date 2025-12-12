<!DOCTYPE html>
<html lang="es">
<head>
    <title>Test Layout</title>
</head>
<body>
    <div style="border: 5px solid red; padding: 20px;">
        <h1>LAYOUT HEADER</h1>
        {{ $slot }}
        <h1>LAYOUT FOOTER</h1>
    </div>
</body>
</html>
