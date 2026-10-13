---
estado: activo
siguiente_paso: Revisar y aprobar el hito 1.5 (rama release/1.5); falta subir la versión y publicarla
bloqueo: ""
actualizado: 2026-10-13
---

# Estado

Plugin de WordPress publicado en WordPress.org; la última versión es la 1.4 (2026-05-22), probada hasta WordPress 7.0 (la actual es la 7.1). En marcha el hito 1.5 (rama release/1.5): corregidos los fallos del análisis y los puntos de seguridad del BACKLOG.md; el código pasa WPCS sin avisos.

## Diario

- 2026-10-13: hito 1.5: corregidos los cuatro fallos (listas, og:image, [lipsum], formatos), comprobación de permisos al guardar, escapado y CSS/JS encolados en admin/. Probado en Playground.
- 2026-10-13: hito 1.5 abierto en la rama release/1.5; su changelog recoge la limpieza de WPCS. Alcance: los apartados «Bugs» y «Security and WordPress.org review» del BACKLOG.md.
- 2026-10-13: código limpio de WPCS (composer lint sin avisos) y probado en Playground (rama fix/phpcs, sin fusionar).
- 2026-10-13: PHPCS configurado con el estándar WordPress completo, prefijo y text domain `quevedo` y `composer lint` (rama chore/phpcs-setup, sin fusionar). Quedan 28 avisos en el código.
- 2026-10-13: backlog con lo que hay que reparar en BACKLOG.md; el blueprint de Playground, fusionado en master.
- 2026-10-13: análisis del código y pruebas en Playground con un blueprint nuevo (rama chore/playground-blueprint, sin fusionar).
- 2026-10-13: guppy/STATUS.md creado.
