# 🚀 API RESTful en PHP

Esta es una API RESTful implementada en PHP que proporciona endpoints para la gestión de usuarios y alumnos. La API incluye funcionalidades de autenticación y operaciones CRUD (Crear, Leer, Actualizar, Eliminar) para alumnos.

## 📝 Descripción

- **Autenticación:** Permite el registro y el inicio de sesión de usuarios.
- **Gestión de Alumnos:** Permite obtener la lista de alumnos, agregar nuevos alumnos, actualizar alumnos existentes y eliminar alumnos.

## 🛠️ Requisitos

- PHP 7.4 o superior
- Composer (para manejar dependencias)
- Un servidor web compatible con PHP (por ejemplo, Apache o Nginx)
- Una base de datos (MySQL, PostgreSQL, etc.)

## 📦 Instalación

1. **Clona el repositorio:** Abre una terminal y ejecuta el siguiente comando para clonar el repositorio desde GitHub:

   ```sh
   git clone <URL_DEL_REPOSITORIO>
   ```

## 🔧 Uso

### Ejemplos de Solicitudes

A continuación, se presentan ejemplos de cómo utilizar cada uno de los endpoints de la API. Puedes probar estos ejemplos usando herramientas como Postman o curl.

#### 📝 Registro de Usuario

- **Endpoint:** `/register`
- **Método:** POST
- **Descripción:** Registra un nuevo usuario en la API.
- **Cuerpo de la Solicitud:**

  ```json
  {
    "email": "usuario@example.com",
    "password": "tu_password"
  }
  ```

- **Ejemplo con curl:**

  ```sh
  curl -X POST http://localhost/api/register \
       -H "Content-Type: application/json" \
       -d '{"email": "usuario@example.com", "password": "tu_password"}'
  ```

- **Respuesta de Ejemplo:**

  ```json
  {
    "message": "Usuario registrado con éxito."
  }
  ```

#### 🔑 Inicio de Sesión

- **Endpoint:** `/login`
- **Método:** POST
- **Descripción:** Inicia sesión y obtiene un token de autenticación.
- **Cuerpo de la Solicitud:**

  ```json
  {
    "email": "usuario@example.com",
    "password": "tu_password"
  }
  ```

- **Ejemplo con curl:**

  ```sh
  curl -X POST http://localhost/api/login \
       -H "Content-Type: application/json" \
       -d '{"email": "usuario@example.com", "password": "tu_password"}'
  ```

- **Respuesta de Ejemplo:**

  ```json
  {
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
  }
  ```

#### 📚 Obtener Lista de Alumnos

- **Endpoint:** `/alumnos`
- **Método:** GET
- **Descripción:** Obtiene la lista de todos los alumnos.
- **Headers:**
  ```
  Authorization: Bearer <tu_token_aqui>
  ```

- **Ejemplo con curl:**

  ```sh
  curl -X GET http://localhost/api/alumnos \
       -H "Authorization: Bearer <tu_token_aqui>"
  ```

- **Respuesta de Ejemplo:**

  ```json
  [
    {
      "id": 1,
      "nombre": "Juan Pérez",
      "email": "juan@example.com"
    },
    ...
  ]
  ```

#### ➕ Agregar un Nuevo Alumno

- **Endpoint:** `/alumnos`
- **Método:** POST
- **Descripción:** Agrega un nuevo alumno.
- **Cuerpo de la Solicitud:**

  ```json
  {
    "nombre": "Nuevo Alumno",
    "email": "nuevoalumno@example.com"
  }
  ```

- **Headers:**
  ```
  Authorization: Bearer <tu_token_aqui>
  ```

- **Ejemplo con curl:**

  ```sh
  curl -X POST http://localhost/api/alumnos \
       -H "Authorization: Bearer <tu_token_aqui>" \
       -H "Content-Type: application/json" \
       -d '{"nombre": "Nuevo Alumno", "email": "nuevoalumno@example.com"}'
  ```

- **Respuesta de Ejemplo:**

  ```json
  {
    "message": "Alumno agregado con éxito."
  }
  ```

#### 🔄 Actualizar un Alumno Existente

- **Endpoint:** `/alumnos`
- **Método:** PUT
- **Descripción:** Actualiza la información de un alumno existente.
- **Cuerpo de la Solicitud:**

  ```json
  {
    "id": 1,
    "nombre": "Juan Pérez Actualizado",
    "email": "juan.actualizado@example.com"
  }
  ```

- **Headers:**
  ```
  Authorization: Bearer <tu_token_aqui>
  ```

- **Ejemplo con curl:**

  ```sh
  curl -X PUT http://localhost/api/alumnos \
       -H "Authorization: Bearer <tu_token_aqui>" \
       -H "Content-Type: application/json" \
       -d '{"id": 1, "nombre": "Juan Pérez Actualizado", "email": "juan.actualizado@example.com"}'
  ```

- **Respuesta de Ejemplo:**

  ```json
  {
    "message": "Alumno actualizado con éxito."
  }
  ```

#### ❌ Eliminar un Alumno

- **Endpoint:** `/alumnos`
- **Método:** DELETE
- **Descripción:** Elimina un alumno existente.
- **Cuerpo de la Solicitud:**

  ```json
  {
    "id": 1
  }
  ```

- **Headers:**
  ```
  Authorization: Bearer <tu_token_aqui>
  ```

- **Ejemplo con curl:**

  ```sh
  curl -X DELETE http://localhost/api/alumnos \
       -H "Authorization: Bearer <tu_token_aqui>" \
       -H "Content-Type: application/json" \
       -d '{"id": 1}'
  ```

## ⚠️ Manejo de Errores

La API devuelve códigos de estado HTTP adecuados para indicar el resultado de cada solicitud. Los errores se devuelven en formato JSON con un mensaje descriptivo.

- Código 404: Ruta no encontrada.
- Código 401: No autorizado (token de autenticación inválido o ausente).
- Código 400: Solicitud incorrecta (datos inválidos o incompletos).

