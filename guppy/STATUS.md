---
estado: activo
siguiente_paso: Publicar la 1.5 en WordPress.org por SVN; antes, decidir quién instala el cliente svn y si se añade un Upgrade Notice
bloqueo: ""
actualizado: 2026-10-13
---

# Estado

Plugin de WordPress publicado en WordPress.org. La 1.5 está publicada en GitHub (etiqueta v1.5) y pendiente de subir a WordPress.org: fallos del análisis, seguridad, accesibilidad, PHP 8.2 y traducciones solo desde translate.wordpress.org. El código pasa WPCS y Plugin Check sin errores.

## Publicar la 1.5 en WordPress.org (pendiente)

Situación del SVN (https://plugins.svn.wordpress.org/quevedo/) el 2026-10-13:

- `trunk/` está en la 1.4 y lleva archivos de desarrollo que llegan a los usuarios: `README.md`, `phpcs.xml` y `assets/` (banners e iconos).
- `tags/`: 1.0, 1.1, 1.3 y 1.4. La carpeta `assets/` de la raíz tiene los banners y los iconos de la página del plugin.
- En este equipo solo está TortoiseSVN, sin el cliente de línea de comandos (`svn.exe`).

Plan acordado:

1. Instalar el cliente svn (opción «command line client tools» de TortoiseSVN, o SlikSVN con winget). Falta decidir si lo instala Nilo o Claude.
2. Decidir si se añade `== Upgrade Notice ==` al `readme.txt` por el salto a PHP 8.2. Si se añade, hay que hacerlo antes del paso 4, y la etiqueta v1.5 tendría que moverse o pasar a ser una 1.5.1.
3. Copia de trabajo fuera del repo (por ejemplo `D:\svn\quevedo`), solo con `trunk/` y `assets/`.
4. Sustituir `trunk/` por el contenido de `git archive v1.5`, marcar altas y bajas con `svn status` y copiar `trunk/` a `tags/1.5` con `svn cp`, en el mismo commit.
5. Comparar `assets/` de la raíz con `assets/` del repo; solo se toca si difieren.
6. Enseñar a Nilo el `svn status` y el `svn diff` antes del commit. El commit lo hace Nilo, con la contraseña SVN de su cuenta de WordPress.org.
7. Después, descargar el zip de wordpress.org y compararlo con `git archive v1.5`, y revisar la página del plugin (versión 1.5, Requires PHP 8.2).

## Entorno de pruebas

- Sitio de Studio en `C:\Users\manolito\Studio\quevedo` (http://quevedo.local/, admin / password), en español, con el plugin enlazado desde el repo y Plugin Check instalado. Está parado; se arranca con `studio start --path "C:\Users\manolito\Studio\quevedo" --skip-browser` o desde la aplicación de Studio.
- Para Playground: `blueprint.json` en la raíz del repo. El puerto 9400 puede estar ocupado por otro proyecto: usar `--port 9401` junto con `--site-url`.

## Diario

- 2026-10-13: sesión cerrada. Plan de publicación por SVN documentado arriba; servidores parados.
- 2026-10-13: versión 1.5 publicada en GitHub (etiqueta v1.5), probada en Studio con WordPress 7.1.3.
- 2026-10-13: hito 1.5 fusionado en master. Plugin Check sin errores en el sitio de Studio (Studio/quevedo); su único aviso (load_plugin_textdomain) se resuelve quitando las traducciones incluidas, que ya llegan de translate.wordpress.org (rama chore/remove-bundled-translations, sin fusionar).
- 2026-10-13: hito 1.5: etiquetas ocultas y redirigidas, páginas de adjunto con el ajuste de WordPress, una sola redirección, imagen por defecto solo en la web, botón «Select image», interruptores accesibles, erratas (cadenas nuevas sin traducir), PHP 8.2 y Tested up to 7.1.
- 2026-10-13: hito 1.5: corregidos los cuatro fallos (listas, og:image, [lipsum], formatos), comprobación de permisos al guardar, escapado y CSS/JS encolados en admin/. Probado en Playground.
- 2026-10-13: hito 1.5 abierto en la rama release/1.5; su changelog recoge la limpieza de WPCS. Alcance: los apartados «Bugs» y «Security and WordPress.org review» del BACKLOG.md.
- 2026-10-13: código limpio de WPCS (composer lint sin avisos) y probado en Playground (rama fix/phpcs, sin fusionar).
- 2026-10-13: PHPCS configurado con el estándar WordPress completo, prefijo y text domain `quevedo` y `composer lint` (rama chore/phpcs-setup, sin fusionar). Quedan 28 avisos en el código.
- 2026-10-13: backlog con lo que hay que reparar en BACKLOG.md; el blueprint de Playground, fusionado en master.
- 2026-10-13: análisis del código y pruebas en Playground con un blueprint nuevo (rama chore/playground-blueprint, sin fusionar).
- 2026-10-13: guppy/STATUS.md creado.
