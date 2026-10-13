---
estado: activo
siguiente_paso: Aprobar la rama chore/remove-bundled-translations; después, pruebas reales en Studio, subir la versión a 1.5 y publicarla
bloqueo: ""
actualizado: 2026-10-13
---

# Estado

Plugin de WordPress publicado en WordPress.org; la última versión publicada es la 1.4 (2026-05-22). Los cambios de la 1.5 están en master, sin publicar todavía: fallos del análisis, seguridad, accesibilidad y PHP 8.2. El código pasa WPCS y Plugin Check sin errores.

## Diario

- 2026-10-13: hito 1.5 fusionado en master. Plugin Check sin errores en el sitio de Studio (Studio/quevedo); su único aviso (load_plugin_textdomain) se resuelve quitando las traducciones incluidas, que ya llegan de translate.wordpress.org (rama chore/remove-bundled-translations, sin fusionar).
- 2026-10-13: hito 1.5: etiquetas ocultas y redirigidas, páginas de adjunto con el ajuste de WordPress, una sola redirección, imagen por defecto solo en la web, botón «Select image», interruptores accesibles, erratas (cadenas nuevas sin traducir), PHP 8.2 y Tested up to 7.1.
- 2026-10-13: hito 1.5: corregidos los cuatro fallos (listas, og:image, [lipsum], formatos), comprobación de permisos al guardar, escapado y CSS/JS encolados en admin/. Probado en Playground.
- 2026-10-13: hito 1.5 abierto en la rama release/1.5; su changelog recoge la limpieza de WPCS. Alcance: los apartados «Bugs» y «Security and WordPress.org review» del BACKLOG.md.
- 2026-10-13: código limpio de WPCS (composer lint sin avisos) y probado en Playground (rama fix/phpcs, sin fusionar).
- 2026-10-13: PHPCS configurado con el estándar WordPress completo, prefijo y text domain `quevedo` y `composer lint` (rama chore/phpcs-setup, sin fusionar). Quedan 28 avisos en el código.
- 2026-10-13: backlog con lo que hay que reparar en BACKLOG.md; el blueprint de Playground, fusionado en master.
- 2026-10-13: análisis del código y pruebas en Playground con un blueprint nuevo (rama chore/playground-blueprint, sin fusionar).
- 2026-10-13: guppy/STATUS.md creado.
