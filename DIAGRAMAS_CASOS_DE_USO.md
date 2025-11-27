# Diagramas de Casos de Uso - Sistema de Administración LTA

Este documento contiene todos los diagramas de casos de uso en formato Mermaid para el sistema de administración LTA.

---

## Diagrama 1: Caso de Uso General del Sistema

```mermaid
graph TB
    Admin[👤 Administrador]
    System[("Sistema de Administración LTA")]
    
    subgraph Modulo1["📊 Dashboard"]
        UC1[Ver Dashboard Principal]
    end
    
    subgraph Modulo2["🏢 Gestión de Fundaciones"]
        UC2[Gestionar Fundaciones]
    end
    
    subgraph Modulo3["🤝 Gestión de Proveedores"]
        UC3[Gestionar Proveedores]
    end
    
    subgraph Modulo4["📦 Gestión de Productos"]
        UC4[Gestionar Productos]
    end
    
    subgraph Modulo5["🏷️ Gestión de Categorías"]
        UC5[Gestionar Categorías]
    end
    
    subgraph Modulo6["👥 Gestión de Usuarios"]
        UC6[Gestionar Usuarios]
    end
    
    subgraph Modulo7["🛒 Gestión de Carritos"]
        UC7[Gestionar Carritos]
    end
    
    subgraph Modulo8["📋 Gestión de Órdenes"]
        UC8[Gestionar Órdenes]
    end
    
    subgraph Modulo9["💳 Gestión de Pagos"]
        UC9[Gestionar Pagos]
    end
    
    Admin -->|Accede a| System
    System --> Modulo1
    System --> Modulo2
    System --> Modulo3
    System --> Modulo4
    System --> Modulo5
    System --> Modulo6
    System --> Modulo7
    System --> Modulo8
    System --> Modulo9
```

---

## Diagrama 2: Caso de Uso de Funcionalidades Detalladas

```mermaid
graph TB
    Admin[👤 Administrador]
    
    subgraph Auth["🔐 Autenticación"]
        UC_Auth1[Iniciar Sesión]
        UC_Auth2[Cerrar Sesión]
    end
    
    subgraph Dashboard["📊 Dashboard"]
        UC_Dash1[Ver Dashboard Principal]
        UC_Dash2[Ver Estadísticas de Fundaciones]
        UC_Dash3[Ver Estadísticas de Proveedores]
        UC_Dash4[Ver Estadísticas de Productos]
        UC_Dash5[Ver Estadísticas de Órdenes]
    end
    
    subgraph Fundaciones["🏢 Fundaciones"]
        UC_F1[Crear Fundación]
        UC_F2[Listar Fundaciones]
        UC_F3[Editar Fundación]
        UC_F4[Eliminar Fundación]
    end
    
    subgraph Proveedores["🤝 Proveedores"]
        UC_P1[Crear Proveedor]
        UC_P2[Listar Proveedores]
        UC_P3[Editar Proveedor]
        UC_P4[Eliminar Proveedor]
    end
    
    subgraph Productos["📦 Productos"]
        UC_Prod1[Crear Producto]
        UC_Prod2[Listar Productos]
        UC_Prod3[Editar Producto]
        UC_Prod4[Eliminar Producto]
        UC_Prod5[Filtrar por Categoría]
        UC_Prod6[Filtrar por Proveedor]
    end
    
    subgraph Categorias["🏷️ Categorías"]
        UC_Cat1[Crear Categoría]
        UC_Cat2[Listar Categorías]
        UC_Cat3[Editar Categoría]
        UC_Cat4[Eliminar Categoría]
    end
    
    subgraph Usuarios["👥 Usuarios"]
        UC_U1[Crear Usuario]
        UC_U2[Listar Usuarios]
        UC_U3[Editar Usuario]
        UC_U4[Eliminar Usuario]
    end
    
    subgraph Carritos["🛒 Carritos"]
        UC_Car1[Listar Carritos]
        UC_Car2[Ver Detalles de Carrito]
        UC_Car3[Eliminar Carrito]
    end
    
    subgraph Ordenes["📋 Órdenes"]
        UC_Ord1[Listar Órdenes]
        UC_Ord2[Ver Detalles de Orden]
        UC_Ord3[Editar Estado de Orden]
        UC_Ord4[Eliminar Orden]
    end
    
    subgraph Pagos["💳 Pagos"]
        UC_Pay1[Crear Pago]
        UC_Pay2[Listar Pagos]
        UC_Pay3[Ver Detalles de Pago]
        UC_Pay4[Editar Pago]
        UC_Pay5[Eliminar Pago]
    end
    
    Admin --> Auth
    Admin --> Dashboard
    Admin --> Fundaciones
    Admin --> Proveedores
    Admin --> Productos
    Admin --> Categorias
    Admin --> Usuarios
    Admin --> Carritos
    Admin --> Ordenes
    Admin --> Pagos
```

---

## Diagrama 3: Caso de Uso por Actor - Administrador

```mermaid
graph TB
    Admin[👤 Administrador]
    
    subgraph Contenido["📦 Gestión de Contenido"]
        UC_Cont1[Gestionar Fundaciones]
        UC_Cont2[Gestionar Proveedores]
        UC_Cont3[Gestionar Productos]
        UC_Cont4[Gestionar Categorías]
    end
    
    subgraph Usuarios["👥 Gestión de Usuarios"]
        UC_Usr1[Gestionar Usuarios del Sistema]
    end
    
    subgraph Transacciones["💼 Gestión de Transacciones"]
        UC_Trans1[Consultar Carritos]
        UC_Trans2[Gestionar Órdenes]
        UC_Trans3[Gestionar Pagos]
    end
    
    subgraph Reportes["📊 Reportes y Análisis"]
        UC_Rep1[Ver Dashboard Principal]
        UC_Rep2[Ver Estadísticas Generales]
        UC_Rep3[Ver Reportes de Ventas]
        UC_Rep4[Ver Reportes de Inventario]
    end
    
    subgraph Seguridad["🔐 Autenticación"]
        UC_Sec1[Iniciar Sesión]
        UC_Sec2[Cerrar Sesión]
    end
    
    Admin --> Contenido
    Admin --> Usuarios
    Admin --> Transacciones
    Admin --> Reportes
    Admin --> Seguridad
```

---

## Diagrama 3b: Caso de Uso por Actor - Usuario del Sistema (Futuro)

```mermaid
graph TB
    Usuario[👤 Usuario del Sistema]
    
    subgraph Navegacion["🔍 Navegación"]
        UC_Nav1[Ver Catálogo de Productos]
        UC_Nav2[Buscar Productos]
        UC_Nav3[Filtrar Productos]
    end
    
    subgraph Carrito["🛒 Carrito"]
        UC_Car1[Agregar Productos al Carrito]
        UC_Car2[Ver Carrito]
        UC_Car3[Modificar Cantidades]
        UC_Car4[Eliminar Items del Carrito]
    end
    
    subgraph Ordenes["📋 Órdenes"]
        UC_Ord1[Crear Orden desde Carrito]
        UC_Ord2[Ver Mis Órdenes]
        UC_Ord3[Ver Detalles de Orden]
    end
    
    subgraph Pagos["💳 Pagos"]
        UC_Pay1[Realizar Pago de Orden]
        UC_Pay2[Ver Historial de Pagos]
    end
    
    subgraph Perfil["👤 Perfil"]
        UC_Per1[Ver Perfil]
        UC_Per2[Editar Perfil]
    end
    
    subgraph Auth["🔐 Autenticación"]
        UC_Auth1[Registrarse]
        UC_Auth2[Iniciar Sesión]
        UC_Auth3[Cerrar Sesión]
        UC_Auth4[Recuperar Contraseña]
    end
    
    Usuario --> Navegacion
    Usuario --> Carrito
    Usuario --> Ordenes
    Usuario --> Pagos
    Usuario --> Perfil
    Usuario --> Auth
```

---

## Diagrama 4: Caso de Uso con Relaciones y Dependencias

```mermaid
graph TB
    Admin[👤 Administrador]
    
    subgraph CRUD["Operaciones CRUD"]
        UC_Create[Crear]
        UC_Read[Listar/Ver]
        UC_Update[Editar]
        UC_Delete[Eliminar]
    end
    
    subgraph Validaciones["Validaciones"]
        Val1[Validar Dependencias]
        Val2[Validar Productos Asociados]
        Val3[Validar Carritos Activos]
        Val4[Validar Orden]
        Val5[Validar Carrito]
    end
    
    subgraph Auth["Autenticación"]
        Auth_UC[Autenticación Requerida]
    end
    
    UC_Delete -.->|extend| Val1
    UC_Delete -.->|extend| Val2
    UC_Delete -.->|extend| Val3
    
    UC_Create -.->|include| Auth_UC
    UC_Read -.->|include| Auth_UC
    UC_Update -.->|include| Auth_UC
    UC_Delete -.->|include| Auth_UC
    
    subgraph Fundaciones["Fundaciones"]
        UC_F_Create[Crear Fundación]
        UC_F_Delete[Eliminar Fundación]
    end
    
    subgraph Proveedores["Proveedores"]
        UC_Prov_Create[Crear Proveedor]
        UC_Prov_Delete[Eliminar Proveedor]
    end
    
    subgraph Productos["Productos"]
        UC_Prod_Create[Crear Producto]
        UC_Prod_Delete[Eliminar Producto]
    end
    
    subgraph Ordenes["Órdenes"]
        UC_Ord_Create[Crear Orden]
        UC_Ord_Pay[Realizar Pago]
    end
    
    UC_F_Delete -.->|extend| Val1
    UC_Prov_Delete -.->|extend| Val2
    UC_Prod_Delete -.->|extend| Val3
    UC_Ord_Create -.->|include| Val5
    UC_Ord_Pay -.->|include| Val4
    
    Admin --> Fundaciones
    Admin --> Proveedores
    Admin --> Productos
    Admin --> Ordenes
```

---

## Diagrama 5a: Caso de Uso - Módulo Gestión de Fundaciones

```mermaid
graph TB
    Admin[👤 Administrador]
    
    subgraph Fundaciones["🏢 Módulo: Gestión de Fundaciones"]
        UC_F1[Crear Fundación]
        UC_F2[Listar Fundaciones]
        UC_F3[Editar Fundación]
        UC_F4[Eliminar Fundación]
        UC_F5[Verificar Fundación]
        UC_F6[Activar/Desactivar Fundación]
    end
    
    Admin -->|Gestiona| Fundaciones
```

---

## Diagrama 5b: Caso de Uso - Módulo Gestión de Proveedores

```mermaid
graph TB
    Admin[👤 Administrador]
    
    subgraph Proveedores["🤝 Módulo: Gestión de Proveedores"]
        UC_P1[Crear Proveedor]
        UC_P2[Listar Proveedores]
        UC_P3[Editar Proveedor]
        UC_P4[Eliminar Proveedor]
        UC_P5[Activar/Desactivar Proveedor]
        UC_P6[Ver Productos del Proveedor]
    end
    
    Admin -->|Gestiona| Proveedores
```

---

## Diagrama 5c: Caso de Uso - Módulo Gestión de Productos

```mermaid
graph TB
    Admin[👤 Administrador]
    
    subgraph Productos["📦 Módulo: Gestión de Productos"]
        UC_Prod1[Crear Producto]
        UC_Prod2[Listar Productos]
        UC_Prod3[Editar Producto]
        UC_Prod4[Eliminar Producto]
        UC_Prod5[Asignar Categoría]
        UC_Prod6[Gestionar Stock]
        UC_Prod7[Cambiar Estado del Producto]
    end
    
    Admin -->|Gestiona| Productos
```

---

## Diagrama 5d: Caso de Uso - Módulo Gestión de Categorías

```mermaid
graph TB
    Admin[👤 Administrador]
    
    subgraph Categorias["🏷️ Módulo: Gestión de Categorías"]
        UC_Cat1[Crear Categoría]
        UC_Cat2[Listar Categorías]
        UC_Cat3[Editar Categoría]
        UC_Cat4[Eliminar Categoría]
        UC_Cat5[Ver Productos por Categoría]
    end
    
    Admin -->|Gestiona| Categorias
```

---

## Diagrama 5e: Caso de Uso - Módulo Gestión de Usuarios

```mermaid
graph TB
    Admin[👤 Administrador]
    
    subgraph Usuarios["👥 Módulo: Gestión de Usuarios"]
        UC_U1[Crear Usuario]
        UC_U2[Listar Usuarios]
        UC_U3[Editar Usuario]
        UC_U4[Eliminar Usuario]
        UC_U5[Cambiar Contraseña de Usuario]
    end
    
    Admin -->|Gestiona| Usuarios
```

---

## Diagrama 5f: Caso de Uso - Módulo Gestión de Carritos

```mermaid
graph TB
    Admin[👤 Administrador]
    
    subgraph Carritos["🛒 Módulo: Gestión de Carritos"]
        UC_Car1[Listar Carritos]
        UC_Car2[Ver Detalles de Carrito]
        UC_Car3[Eliminar Carrito]
        UC_Car4[Ver Items del Carrito]
    end
    
    Admin -->|Consulta| Carritos
```

---

## Diagrama 5g: Caso de Uso - Módulo Gestión de Órdenes

```mermaid
graph TB
    Admin[👤 Administrador]
    
    subgraph Ordenes["📋 Módulo: Gestión de Órdenes"]
        UC_Ord1[Listar Órdenes]
        UC_Ord2[Ver Detalles de Orden]
        UC_Ord3[Cambiar Estado de Orden]
        UC_Ord4[Eliminar Orden]
        UC_Ord5[Ver Pagos de la Orden]
    end
    
    Admin -->|Gestiona| Ordenes
```

---

## Diagrama 5h: Caso de Uso - Módulo Gestión de Pagos

```mermaid
graph TB
    Admin[👤 Administrador]
    
    subgraph Pagos["💳 Módulo: Gestión de Pagos"]
        UC_Pay1[Crear Pago]
        UC_Pay2[Listar Pagos]
        UC_Pay3[Ver Detalles de Pago]
        UC_Pay4[Editar Pago]
        UC_Pay5[Eliminar Pago]
        UC_Pay6[Cambiar Estado de Pago]
    end
    
    Admin -->|Gestiona| Pagos
```

---

## Diagrama 5i: Caso de Uso - Módulo Dashboard y Reportes

```mermaid
graph TB
    Admin[👤 Administrador]
    
    subgraph Dashboard["📊 Módulo: Dashboard y Reportes"]
        UC_Dash1[Ver Dashboard Principal]
        UC_Dash2[Ver Estadísticas de Fundaciones]
        UC_Dash3[Ver Estadísticas de Proveedores]
        UC_Dash4[Ver Estadísticas de Productos]
        UC_Dash5[Ver Estadísticas de Órdenes]
        UC_Dash6[Ver Estadísticas de Ingresos]
        UC_Dash7[Exportar Reportes]
    end
    
    Admin -->|Consulta| Dashboard
```

---

## Diagrama 5j: Caso de Uso - Módulo Autenticación

```mermaid
graph TB
    Admin[👤 Administrador]
    Usuario[👤 Usuario del Sistema]
    
    subgraph Auth["🔐 Módulo: Autenticación"]
        UC_Auth1[Iniciar Sesión]
        UC_Auth2[Cerrar Sesión]
        UC_Auth3[Recuperar Contraseña]
    end
    
    Admin -->|Utiliza| Auth
    Usuario -->|Utiliza| Auth
```

---

## Notas sobre los Diagramas

1. **Símbolos utilizados:**
   - 👤 = Actor (Usuario/Administrador)
   - 📊 = Dashboard/Reportes
   - 🏢 = Fundaciones
   - 🤝 = Proveedores
   - 📦 = Productos
   - 🏷️ = Categorías
   - 👥 = Usuarios
   - 🛒 = Carritos
   - 📋 = Órdenes
   - 💳 = Pagos
   - 🔐 = Autenticación

2. **Relaciones:**
   - `-->` = Relación directa (Actor realiza caso de uso)
   - `-.->` = Relación de dependencia (include/extend)

3. **Uso:**
   - Estos diagramas pueden copiarse directamente en herramientas que soporten Mermaid
   - Compatible con: GitHub, GitLab, Notion, Obsidian, y muchas otras plataformas
   - También pueden renderizarse en: https://mermaid.live/

---

## Diagrama Completo Consolidado (Opcional)

```mermaid
graph TB
    Admin[👤 Administrador]
    
    subgraph Sistema["Sistema de Administración LTA"]
        Dashboard["📊 Dashboard"]
        Fundaciones["🏢 Fundaciones"]
        Proveedores["🤝 Proveedores"]
        Productos["📦 Productos"]
        Categorias["🏷️ Categorías"]
        Usuarios["👥 Usuarios"]
        Carritos["🛒 Carritos"]
        Ordenes["📋 Órdenes"]
        Pagos["💳 Pagos"]
        Auth["🔐 Autenticación"]
    end
    
    Admin --> Sistema
    
    Sistema --> Dashboard
    Sistema --> Fundaciones
    Sistema --> Proveedores
    Sistema --> Productos
    Sistema --> Categorias
    Sistema --> Usuarios
    Sistema --> Carritos
    Sistema --> Ordenes
    Sistema --> Pagos
    Sistema --> Auth
    
    style Admin fill:#e1f5ff
    style Sistema fill:#f0f0f0
    style Dashboard fill:#fff4e6
    style Fundaciones fill:#e8f5e9
    style Proveedores fill:#e3f2fd
    style Productos fill:#fce4ec
    style Categorias fill:#f3e5f5
    style Usuarios fill:#e0f2f1
    style Carritos fill:#fff9c4
    style Ordenes fill:#e1bee7
    style Pagos fill:#c8e6c9
    style Auth fill:#ffccbc
```

