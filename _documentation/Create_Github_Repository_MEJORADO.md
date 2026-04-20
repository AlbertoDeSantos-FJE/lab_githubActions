# 🧑‍💻 Crear y subir un proyecto Laravel a GitHub (Guía completa para clase)

------------------------------------------------------------------------

## 🎯 Objetivo

Subir un proyecto local de Laravel a GitHub correctamente usando Git.

------------------------------------------------------------------------

## ✅ Checklist antes de empezar

-   Tener Git instalado → `git --version`
-   Tener cuenta en GitHub
-   Tener proyecto Laravel funcionando en local

------------------------------------------------------------------------

## 1️⃣ Inicializar Git en el proyecto

``` bash
cd ruta/a/tu/proyecto
git init
```

✔️ Comprueba:

``` bash
git status
```

------------------------------------------------------------------------

## 2️⃣ Revisar el archivo .gitignore

Laravel ya incluye uno, pero verifica que contiene:

-   /vendor
-   /node_modules
-   .env

❗ IMPORTANTE: Nunca subir archivos sensibles como `.env`

------------------------------------------------------------------------

## 3️⃣ Primer commit

``` bash
git add .
git commit -m "Primer commit proyecto Laravel"
```

✔️ Comprueba:

``` bash
git log --oneline
```

------------------------------------------------------------------------

## 4️⃣ Crear repositorio en GitHub

1.  Ir a https://github.com
2.  Pulsar **New repository**
3.  Introducir nombre

❗ NO marcar: - Add README - Add .gitignore - Add license

✔️ Resultado esperado: Repositorio vacío creado

------------------------------------------------------------------------

## 5️⃣ Conectar repositorio local con GitHub

GitHub te mostrará estos comandos:

``` bash
git remote add origin https://github.com/usuario/repositorio.git
git branch -M main
git push -u origin main
```

✔️ Comprueba: - El proyecto aparece en GitHub

------------------------------------------------------------------------

## 6️⃣ Autenticación

GitHub requiere:

### Opción A (rápida): Token personal (PAT)

-   Se usa como contraseña

### Opción B (recomendada): SSH

``` bash
ssh-keygen -t ed25519 -C "tu_email@example.com"
```

Añadir la clave pública a GitHub: Settings → SSH and GPG keys

------------------------------------------------------------------------

## 7️⃣ Flujo de trabajo básico (IMPORTANTE)

Cada vez que hagas cambios:

``` bash
git add .
git commit -m "Descripción del cambio"
git push
```

------------------------------------------------------------------------

## 8️⃣ Trabajo con ramas (nivel intermedio)

Crear una rama nueva:

``` bash
git checkout -b feature/nueva-funcionalidad
```

Subirla:

``` bash
git push -u origin feature/nueva-funcionalidad
```

------------------------------------------------------------------------

## 9️⃣ Clonar el proyecto correctamente

``` bash
git clone https://github.com/usuario/repositorio.git
cd repositorio
composer install
cp .env.example .env
php artisan key:generate
```

------------------------------------------------------------------------

## 🧪 Actividad práctica (para clase)

### Parte 1

-   Inicializar repositorio
-   Hacer primer commit

### Parte 2

-   Crear repo en GitHub
-   Subir proyecto

### Parte 3

-   Crear una rama `feature/test`
-   Subirla

### Validación docente

El alumno debe: - Mostrar repo en GitHub - Tener al menos 2 commits -
Tener una rama creada

------------------------------------------------------------------------

## ⚠️ Errores comunes

❌ Subir `.env`\
❌ Crear README en GitHub antes\
❌ No hacer commit antes de push\
❌ Olvidar `composer install` al clonar

------------------------------------------------------------------------

## 🧠 Conceptos clave

-   **Repositorio**: proyecto versionado
-   **Commit**: punto de guardado
-   **Branch**: línea de desarrollo
-   **Remote**: repositorio en la nube

------------------------------------------------------------------------

## 🚀 Extra (opcional)

Ver repositorio remoto:

``` bash
git remote -v
```

Ver ramas locales y remotas (muestra tanto las ramas del lado del PC como las que Git conoce que existen en el servidor (GitHub):

``` bash
git branch -a
```

Mostrar detalles de ramas (úkltimo commit y relación con remoto)

``` bash
git branch -vv
```

Pueden aparecer ramas que una vez se usasen pero ya no se usan. Por ejemplo, si se ve remotes/origin/nombre-de-la-rama, pero esa rama no está en la lista de ramas locales (git branch), significa que esa rama existe en GitHub pero no en local. Para eliminarla localmente:  

``` bash
git fetch origin --prune
```

**fetch** pregunta a Github qué ramas existen en el servidor y actualiza la lista de ramas locales y **prune** elimina las ramas locales que no existen en el servidor.

La rama **remotes/origin/nombre-de-la-rama** es una rama remota, es decir, una rama que existe en GitHub pero no en local.
La rama **remotes/origin/HEAD** indica cuál es la rama por defecto en el repositorio remoto. Por lo tanto, si en el repositorio remoto la rama por defecto es **main**, entonces **remotes/origin/HEAD** apuntará a **remotes/origin/main**.


Para eliminar una rama local que ya no se usa. git detecta si esa rama está "desfasada" (es decir, si ya no se usa) o si hay cambios en esa rama que no están en ningún otro lado, y te impide borrarla si hay cambios que se perderían, mostrando un error:

``` bash
git branch -d nombre-de-la-rama
```

Borrado forzado (si estás seguro de que quieres borrar la rama, aunque tenga cambios que no están en ningún otro lado):

``` bash
git branch -D nombre-de-la-rama
```

No se puede borrar la rama en la que estás actualmente. Primero te has de mover a otra rama, por ejemplo a la rama main:

``` bash
git checkout main  # o git switch main
git branch -d nombre-de-la-rama
```

Anular un commit. Hay dos opciones:

Para eliminar el último commit en Git utiliza ``` bash git reset --soft HEAD~1 ```para mantener los cambios en local o ``` bash git reset --hard HEAD~1 ``` para borrarlos por completo. 
Si ya hiciste push, usa ``` bash git revert  <commit>``` bash  para crear un nuevo commit que deshaga los cambios de forma segura sin reescribir el historial compartido. 

# Escenario 1: El commit está solo en tu máquina (No has hecho push) 

1. __Mantener los cambios__: Si quieres borrar el commit pero conservar los archivos modificados en tu zona de trabajo (staging), usa ``` bash git reset --soft HEAD~1 ```

2. __Borrar todo por completo__: Si quieres eliminar el commit y todos los cambios asociados (volver al estado anterior por completo), usa: ``` bash git reset --hard HEAD~1 ```    

# Escenario 2: El commit ya está en el repositorio remoto (push realizado) 

1. Lo más seguro (Revertir): Crea un nuevo commit que deshaga los cambios del anterior. Es la mejor opción si compartes la rama:

``` bash
git log # Encuentra el hash del commit
git revert <hash_del_commit>
git push origin <nombre_de_la_rama>
```
2. Forzar la eliminación (Peligroso): Si eres el único trabajando en la rama, puedes resetear localmente y forzar el push:

``` bash
git reset --hard HEAD~1
git push origin <nombre_de_la_rama> --force
```

[Guía de cómo deshacer un commit en Git](https://www.youtube.com/shorts/Ocz-_cvKijk)

