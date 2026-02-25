// Onboarding para usuario 'user' usando Driver.js vía CDN
(function () {
  document.addEventListener('DOMContentLoaded', function () {
    // 1) Verificar Driver.js (CDN)
    const driverFactory = (window && window.driver && window.driver.js && window.driver.js.driver) ? window.driver.js.driver : null;
    if (!driverFactory) return; // Si Driver.js no está disponible, no ejecutar

    // 2) Resolver ID de usuario (se usa 'anon' si no hay ID válido)
    const dataEl = document.getElementById('data_user');
    const userIdAttr = dataEl ? dataEl.getAttribute('data-user-id') : null;
    const userId = (userIdAttr && userIdAttr.trim() !== '') ? userIdAttr.trim() : 'anon';

    // 3) Ruta actual (no redeclarar esta variable en el archivo)
    const routePath = (window.location.pathname || '').toLowerCase();

    // 4) Determinar contexto del tour
    //    - Preferir window.SIIA_TOUR_CONTEXT si está definido (p.ej.: 'panel', 'solicitudes')
    //    - Fallback por ruta: si incluye '/organizacion/solicitudes' => 'solicitudes', de lo contrario 'panel'
    var ctx = (typeof window.SIIA_TOUR_CONTEXT === 'string' && window.SIIA_TOUR_CONTEXT)
      ? window.SIIA_TOUR_CONTEXT.toLowerCase()
      : (routePath.includes('/organizacion/solicitudes') ? 'solicitudes' : (routePath.includes('/organizacion/facilitadores') ? 'facilitadores' : 'panel'));

    // 5) Llave de localStorage por contexto y usuario (evita que un contexto bloquee otro)
    const flagKey = 'siia_onboarding_' + ctx + '_shown_user_' + userId;

    // 6) Permitir forzar el tour (pruebas) con ?tour=1 o window.SIIA_TOUR_FORCE = true
    const isForced = (new URLSearchParams(window.location.search).get('tour') === '1') || (window.SIIA_TOUR_FORCE === true);

    // 7) Si el flag existe y no está forzado, evitar repetir el tour
    if (localStorage.getItem(flagKey) === '1' && !isForced) return;

    // 8) Resolver base /assets (intenta con style.css; si no, usa origen + '/siia' cuando aplique)
    function resolveAssetsBase() {
      var styleLink = null;
      var links = document.querySelectorAll('link[rel="stylesheet"]');
      for (var i = 0; i < links.length; i++) {
        if (links[i].href.indexOf('/assets/css/style.css') !== -1) {
          styleLink = links[i];
          break;
        }
      }
      var base = styleLink ? styleLink.href.split('/assets/css/')[0] : (window.location.origin + (routePath.indexOf('/siia') !== -1 ? '/siia' : ''));
      return base + '/assets';
    }
    const ASSETS_BASE = resolveAssetsBase();
	// TODO: Crear imagenes para cada paso
    // Pasos generales (landing del usuario)
    const generalSteps = [
      {
        element: '.navbar-brand.brand-logo',
        popover: {
          className: 'siia-driver-popover',
          title: 'Panel principal',
          description: `
            <div>
              <p>Desde aquí puedes volver al panel principal de tu organización.</p>
              <img src="${ASSETS_BASE}/img/siia_logo.png" alt="SIIA" />
            </div>
          `,
          position: 'bottom',
        },
      },
      {
        element: 'a.nav-link[href*="organizacion/solicitudes"]',
        popover: {
          className: 'siia-driver-popover',
          title: 'Solicitudes',
          description: `
            <div>
              <p>Crea y gestiona tus solicitudes de acreditación.</p>
              <img src="${ASSETS_BASE}/img/pages/solicitudes.png" alt="Solicitudes" onerror="this.style.display='none'"/>
            </div>
          `,
          position: 'right',
        },
      },
      {
        element: 'a.nav-link[href*="organizacion/facilitadores"]',
        popover: {
          className: 'siia-driver-popover',
          title: 'Facilitadores',
          description: `
            <div>
              <p>Administra los facilitadores vinculados a tu organización.</p>
              <img src="${ASSETS_BASE}/img/pages/facilitadores.png" alt="Facilitadores" onerror="this.style.display='none'"/>
            </div>
          `,
          position: 'right',
        },
      },
      {
        element: 'a.nav-link[href*="organizacion/perfil"]',
        popover: {
          className: 'siia-driver-popover',
          title: 'Perfil',
          description: `
            <div>
              <p>Actualiza la información de tu organización.</p>
              <img src="${ASSETS_BASE}/img/pages/perfil.png" alt="Perfil" onerror="this.style.display='none'"/>
            </div>
          `,
          position: 'right',
        },
      },
      {
        element: 'a.nav-link[href*="organizacion/ayuda"]',
        popover: {
          className: 'siia-driver-popover',
          title: 'Ayuda',
          description: `
            <div>
              <p>Todo lo que necesitas para resolver tus dudas.</p>
              <img src="${ASSETS_BASE}/img/pages/ayuda.png" alt="Ayuda" onerror="this.style.display='none'"/>
            </div>
          `,
          position: 'right',
        },
      },
      {
        element: '#profileDropdown',
        popover: {
          className: 'siia-driver-popover',
          title: 'Perfil y sesión',
          description: `
            <div>
              <p>Accede a tu perfil y cierra sesión desde aquí.</p>
              <img src="${ASSETS_BASE}/img/pages/sesion.png" alt="Sesión" onerror="this.style.display='none'"/>
            </div>
          `,
          position: 'left',
        },
      },
    ];

    // Pasos del módulo Solicitudes (opción A: auto-detectar por ruta)
    function buildSolicitudesSteps() {
      const steps = [
        {
          element: '.main-panel .content-wrapper',
          popover: {
            className: 'siia-driver-popover',
            title: 'Tus solicitudes',
            description: `
              <div>
                <p>En esta sección ves el listado y estado de tus solicitudes.</p>
                <img src="${ASSETS_BASE}/img/pages/solicitudes-listado.png" alt="Listado" onerror="this.style.display='none'"/>
              </div>
            `,
            position: 'top',
          },
        },
        {
          element: 'a.nav-link[href*="organizacion/solicitudes"]',
          popover: {
            className: 'siia-driver-popover',
            title: 'Acceso al módulo',
            description: `
              <div>
                <p>Puedes entrar al módulo de Solicitudes desde el menú lateral.</p>
                <img src="${ASSETS_BASE}/img/pages/solicitudes-menu.png" alt="Menú Solicitudes" onerror="this.style.display='none'"/>
              </div>
            `,
            position: 'right',
          },
        },
        // Ejemplo genérico: primer table dentro del módulo
        {
          element: '.content-wrapper table',
          popover: {
            className: 'siia-driver-popover',
            title: 'Listado',
            description: `
              <div>
                <p>Aquí ves el detalle (código, estado, acciones).</p>
                <img src="${ASSETS_BASE}/img/pages/solicitudes-tabla.png" alt="Tabla" onerror="this.style.display='none'"/>
              </div>
            `,
            position: 'bottom',
          },
        },
        // Ejemplo genérico: primer formulario (creación/edición)
        {
          element: '#nuevaSolicitud',
          popover: {
            className: 'siia-driver-popover',
            title: 'Crear nuvea solicitud',
            description: `
              <div>
                <p>Aquí puedes crear una nueva solicitud.</p>
                <img src="${ASSETS_BASE}/img/pages/solicitudes-form.png" alt="Crear solicitud" onerror="this.style.display='none'"/>
              </div>
            `,
            position: 'right',
          },
        },
      ];
      // Filtrar pasos cuyas referencias no existan en el DOM actual
      var out = [];
      for (var i = 0; i < steps.length; i++) {
        if (document.querySelector(steps[i].element)) out.push(steps[i]);
      }
      return out;
    };

    // NUEVO: Pasos del módulo 'facilitadores'
    function buildFacilitadoresSteps() {
      var steps = [
        {
          element: '.main-panel .content-wrapper',
          popover: {
            className: 'siia-driver-popover',
            title: 'Facilitadores',
            description: '<div><p>Administra los facilitadores vinculados a tu organización.</p><img src="' + ASSETS_BASE + '/img/pages/facilitadores.png" alt="Facilitadores" onerror="this.style.display=\'none\'"/></div>',
            position: 'top'
          }
        },
        {
          element: 'a.nav-link[href*="organizacion/facilitadores"]',
          popover: {
            className: 'siia-driver-popover',
            title: 'Acceso al módulo',
            description: '<div><p>Ingresa al módulo de Facilitadores desde el menú lateral.</p><img src="' + ASSETS_BASE + '/img/pages/solicitudes-menu.png" alt="Menú" onerror="this.style.display=\'none\'"/></div>',
            position: 'right'
          }
        },
        {
          element: '.content-wrapper table',
          popover: {
            className: 'siia-driver-popover',
            title: 'Listado de facilitadores',
            description: '<div><p>Consulta el listado y estado de tus facilitadores.</p><img src="' + ASSETS_BASE + '/img/pages/solicitudes-tabla.png" alt="Tabla" onerror="this.style.display=\'none\'"/></div>',
            position: 'bottom'
          }
        },
        {
          element: '#nuevoFacilitador',
          popover: {
            className: 'siia-driver-popover',
            title: 'Crear facilitador',
            description: '<div><p>Registra un nuevo facilitador para tu organización.</p><img src="' + ASSETS_BASE + '/img/pages/solicitudes-form.png" alt="Formulario" onerror="this.style.display=\'none\'"/></div>',
            position: 'right'
          }
        }
      ];
      // Filtrar por elementos existentes en el DOM
      var out = [];
      for (var i = 0; i < steps.length; i++) {
        if (document.querySelector(steps[i].element)) out.push(steps[i]);
      }
      return out;
    }

    // 11) Seleccionar pasos según contexto (ahora con 'facilitadores')
    var isSolicitudes = (ctx === 'solicitudes') || routePath.includes('/organizacion/solicitudes');
    var isFacilitadores = (ctx === 'facilitadores') || routePath.includes('/organizacion/facilitadores');
    var selectedSteps = isSolicitudes
      ? buildSolicitudesSteps()
      : (isFacilitadores
          ? buildFacilitadoresSteps()
          : (function () {
              var filtered = [];
              for (var i = 0; i < generalSteps.length; i++) {
                if (document.querySelector(generalSteps[i].element)) filtered.push(generalSteps[i]);
              }
              return filtered;
            })());
    if (selectedSteps.length === 0) return; // No hay elementos para mostrar

    // 12) Configuración del Driver.js
    var drv = driverFactory({
      steps: selectedSteps,
      popoverClass: 'siia-driver-popover',
      showProgress: true,
      smoothScroll: true,
      overlayOpacity: 0.35,
      stagePadding: 8,
      nextBtnText: 'Siguiente',
      prevBtnText: 'Atrás',
      doneBtnText: 'Entendido',
      onDestroyed: function () {
        // Marcar como mostrado al destruir el tour (solo si no está forzado)
        if (!isForced) localStorage.setItem(flagKey, '1');
      }
    });

    // 13) Marcar como mostrado antes de iniciar (solo si no está forzado)
    if (!isForced) localStorage.setItem(flagKey, '1');

    // 14) Iniciar el tour (timeout pequeño para asegurar que el DOM está listo)
    setTimeout(function () {
      try { drv.drive(); } catch (e) { /* evitar romper la página si hay algún error */ }
    }, 250);

    // 15) Notas para ampliación:
    //     - Para añadir nuevos contextos (por ejemplo, 'reportes'), establece window.SIIA_TOUR_CONTEXT = 'reportes' en la vista y crea una función buildReportesSteps().
    //     - Asegúrate de usar selectores que existan en el DOM para evitar pasos vacíos.
    //     - Si quieres que un contexto se pueda re-ejecutar por pruebas, usa ?tour=1 en la URL o window.SIIA_TOUR_FORCE = true antes de cargar el script.
    //     - Los recursos de imágenes asumidos están en ASSETS_BASE + '/img/pages/...' (ajústalos según tus rutas reales).
  });
})();
