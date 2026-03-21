## Guía de Instalación: OpenCode + Antigravity en Windows

Esta guía soluciona los conflictos de compatibilidad entre los comandos de Linux (Bash) y el entorno de Windows (PowerShell/CMD).

## 1. Instalación y Configuración (Git Bash)
Ejecuta estos comandos únicamente en la terminal de Git Bash. No utilices PowerShell para este paso.

```Bash
# 1. Descargar e instalar OpenCode
curl -fsSL https://opencode.ai/install | sh

# 2. Crear el archivo de configuración para que Bash reconozca el comando siempre
echo 'export PATH="$HOME/.opencode/bin:$PATH"' >> ~/.bashrc

# 3. Aplicar los cambios en la sesión actual
source ~/.bashrc
```
Verificación: Escribe ```Bash opencode --version```. Si aparece la versión (ej. 1.2.27), la instalación en Git Bash es correcta.

## 2.Configuración del PATH en Windows
Para que la extensión Antigravity y la terminal de VS Code reconozcan el comando, debemos añadirlo a las Variables de Entorno del sistema.

1. Presiona la tecla Windows y escribe: Variables de entorno.
2. Selecciona Editar las variables de entorno del sistema.
3. Haz clic en el botón Variables de entorno (esquina inferior derecha).
4. En la sección Variables de usuario, busca la variable llamada Path y haz clic en Editar.
5. Haz clic en el botón Nuevo y pega la siguiente ruta (ajustada a tu usuario):

```C:\Users\Alberto\.opencode\bin```

6. Haz clic en Aceptar en todas las ventanas abiertas.

## 3. Integración con VS Code y Antigravity
Para que los cambios surtan efecto en el editor, sigue estos pasos finales:

1. Reiniciar VS Code: Cierra todas las ventanas de VS Code y ábrelo de nuevo (esto es obligatorio para que el programa lea el nuevo Path).

2. Configuración de la Extensión:

Abre la extensión Antigravity en la barra lateral.

Si la extensión sigue sin detectar el binario automáticamente, ve a sus Ajustes (Settings).

En el campo Executable Path o similar, introduce la ruta directa:

```C:\Users\Alberto\.opencode\bin\opencode.exe```

3. Ejecución del comando:
Ahora ya puedes usar el comando en la terminal integrada de VS Code o Antigravity (menú superior derecha):

```PowerShell 
opencode --port 55103
```
Con el comando ```/``` aparece el menú de uso de opencode.

[Ver video de Antigravity y opencode en YouTube](https://www.youtube.com/watch?v=oV4jPxFcQLY&t=449s)
