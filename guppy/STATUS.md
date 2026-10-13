---
estado: activo
siguiente_paso: Corregir los 28 avisos de PHPCS (22 automáticos con composer fix)
bloqueo: ""
actualizado: 2026-10-13
---

# Estado

Plugin de WordPress publicado en WordPress.org; la última versión es la 1.4 (2026-05-22), probada hasta WordPress 7.0 (la actual es la 7.1). Analizado y probado en Playground: funciona en lo básico, pero hay fallos reales (listas con un solo elemento en el editor simplificado, og:image que ignora la imagen propia de la entrada, `[lipsum]` con valores no numéricos) y deuda de estándares (150 avisos de WPCS, casi todos de espaciado).

## Diario

- 2026-10-13: PHPCS configurado con el estándar WordPress completo, prefijo y text domain `quevedo` y `composer lint` (rama chore/phpcs-setup, sin fusionar). Quedan 28 avisos en el código.
- 2026-10-13: backlog con lo que hay que reparar en BACKLOG.md; el blueprint de Playground, fusionado en master.
- 2026-10-13: análisis del código y pruebas en Playground con un blueprint nuevo (rama chore/playground-blueprint, sin fusionar).
- 2026-10-13: guppy/STATUS.md creado.
