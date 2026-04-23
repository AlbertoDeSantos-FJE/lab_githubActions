# Guía de Securización de la Rama Main

Esta guía detalla los pasos necesarios para proteger la rama principal (`main`) en GitHub, asegurando que ningún cambio se integre sin una revisión previa mediante **Pull Request (PR)**.

GitHub reserva las funciones de seguridad avanzada y control de flujo (como proteger ramas en repositorios privados) para sus planes de pago (GitHub Team o Enterprise). En el plan gratuito, solo se pueden usar estas reglas si el repositorio es Público.

Si el repositorio es privado, la regla se guarda, pero GitHub te avisa que "no se aplicará" (no se forzará) hasta que pagues o cambies el tipo de repositorio.

---

## 🛠 Configuración Paso a Paso

### 1. Acceso a la Configuración
1. Navega a la página principal de tu repositorio en GitHub.
2. Haz clic en la pestaña **Settings** (Configuración) en el menú superior.
3. En la barra lateral izquierda, dentro de **Code and automation**, selecciona **Branches**.

### 2. Creación de la Regla de Protección
1. Localiza la sección **Branch protection rules**.
2. Haz clic en el botón **Add branch protection rule**.
3. En el campo **Branch name pattern**, escribe `main`.

### 3. Reglas de Restricción Obligatorias
Para garantizar la integridad del código, activa las siguientes opciones:

* **Require a pull request before merging**: Bloquea los pushes directos.
* **Require approvals**: Selecciona al menos `1` aprobación necesaria.
* **Dismiss stale pull request approvals when new commits are pushed**: Invalida la aprobación si el autor sube nuevos cambios tras la revisión.
* **Do not allow bypassing the above settings**: Aplica estas reglas incluso a los administradores del repositorio.

### 4. Reglas Recomendadas (Opcional)
* **Require status checks to pass before merging**: Impide el merge si las pruebas automáticas (CI/CD) fallan.
* **Require conversation resolution before merging**: Obliga a que todos los comentarios en el código sean marcados como "resueltos".

---

## 🔄 Nuevo Flujo de Trabajo (Workflow)

A partir de ahora, el flujo de trabajo estándar para cualquier colaborador será:

1.  **Crear una rama local**:  
    `git checkout -b feature/nombre-de-la-mejora`
    o
    `git checkout -b fix/descripcion-del-error`
2.  **Subir cambios a la rama**:  
    `git push origin nombre-de-tu-rama`
3.  **Abrir Pull Request**:  
    Desde la interfaz de GitHub, solicitar la integración a `main`.
4.  **Revisión y Aprobación**:  
    Un compañero debe revisar el código y dar su aprobación.
5.  **Merge**:  
    Una vez aprobado (y pasados los tests), se habilita el botón para fusionar con `main`.

> [!CAUTION]
> Si intentas hacer `git push origin main` directamente, el sistema rechazará la operación con un error de protección de rama.

