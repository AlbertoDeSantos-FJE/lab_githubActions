# 🚀 Nombre de tu Proyecto

Una breve descripción de qué hace este proyecto, cuál es su objetivo principal y a quién va dirigido.

## 🛠️ Configuración del Entorno

Sigue estos pasos para configurar el proyecto en tu máquina local:

1. **Clonar el repositorio:**
   ```bash
   git clone [https://github.com/tu-usuario/tu-repositorio.git](https://github.com/tu-usuario/tu-repositorio.git)

2. **Instalar dependencias:**
   ```bash
   composer install
   ```

3. **Configurar variables de entorno:**
   Copia el archivo .env.example a .env y completa los valores necesarios.

   ```bash
   cp .env.example .env
   ```

4. **Generar clave de aplicación:**
   ```bash
   php artisan key:generate
   ```

5. **Ejecutar migraciones:**
   ```bash
   php artisan migrate
   ```

## 👥 Flujo de Trabajo Colaborativo

Para asegurar un desarrollo ordenado y evitar conflictos, sigue estos pasos antes de subir tus cambios:

1. **Actualizar la rama local:**
   Antes de empezar a trabajar, asegúrate de tener la última versión del código:
   ```bash
   git pull origin main
   ```

2. **Crear una rama de trabajo:**
   Nunca trabajes directamente sobre la rama `main`. Crea una rama específica para tu tarea:
   ```bash
   git checkout -b feature/nombre-de-la-funcionalidad
   ```
   o para corrección de errores:
   ```bash
   git checkout -b fix/descripcion-del-error
   ```

3. **Subir cambios a la rama:**
   Una vez que hayas terminado tu trabajo en la rama local:
   ```bash
   git push origin nombre-de-tu-rama
   ```

4. **Abrir un Pull Request (PR):**
   Ve a la interfaz de GitHub y crea un Pull Request para solicitar la fusión de tu rama con `main`. Asegúrate de incluir una descripción clara de los cambios realizados.

5. **Revisión y Aprobación:**
   Espera a que otro miembro del equipo revise tu código y lo apruebe. Una vez aprobado, se podrá fusionar con la rama principal.

## ⚠️ Reglas Importantes

- **Nunca** subas cambios directamente a la rama `main`.
- **Siempre** crea una rama de trabajo para cada nueva funcionalidad o corrección.
- **Siempre** realiza un `git pull` antes de empezar a trabajar para evitar conflictos.
- **Siempre** abre un Pull Request para que tu código sea revisado antes de ser fusionado.
