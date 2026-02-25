document.addEventListener('DOMContentLoaded', () => {
    const dataEl = document.getElementById('data_user');
    const tipoUsuario = (dataEl?.getAttribute('data-tipo-u') || '').toLowerCase();
    if (tipoUsuario !== 'user') return;

    const isForced = new URLSearchParams(window.location.search).get('tour') === '1' || window.SIIA_TOUR_FORCE === true;

    const userIdAttr = dataEl?.getAttribute('data-id-u');
    const userId = userIdAttr && userIdAttr.trim() !== '' ? userIdAttr.trim() : null;
    const KEY = userId ? `siia_tour_solicitudes_shown_user_${userId}` : null;

    if (KEY && localStorage.getItem(KEY) === '1' && !isForced) {
        return; // ya mostrado para este usuario/módulo
    }

    const Driver = window.driver?.js?.driver;
    if (!Driver) {
        console.warn('Driver.js no está cargado (CDN). Revisa header/main.php y la condición de tipo_usuario.');
        return;
    }

  const ASSETS_BASE = (function(){
    const styleLink = Array.from(document.querySelectorAll('link[rel="stylesheet"]'))
      .find(l => l.href.includes('/assets/css/style.css'));
    const base = styleLink ? styleLink.href.split('/assets/css/')[0] : (window.location.origin + (window.location.pathname.includes('/siia') ? '/siia' : ''));
    return base + '/assets';
  })();

  const steps = [
    {
      element: '.main-panel .content-wrapper',
      popover: {
        className: 'siia-driver-popover',
        title: 'Módulo Solicitudes',
        description: `
          <div>
            <p>Gestiona aquí tus solicitudes de acreditación.</p>
            <img src="${ASSETS_BASE}/img/pages/solicitudes-listado.png" alt="Listado" onerror="this.style.display='none'"/>
          </div>
        `,
        position: 'top',
      },
    },
    { element: 'a.nav-link[href*="organizacion/solicitudes"]',
      popover: { className: 'siia-driver-popover', title: 'Menú', description: '<p>Accede desde el menú lateral.</p>', position: 'right' }
    },
    { element: '.content-wrapper table',
      popover: { className: 'siia-driver-popover', title: 'Listado', description: '<p>Detalle de tus solicitudes.</p>', position: 'bottom' }
    },
    { element: '#solicitud-form',
      popover: { className: 'siia-driver-popover', title: 'Formulario', description: '<p>Crea o edita la solicitud.</p>', position: 'right' }
    },
  ];
    const filteredSteps = steps.filter(({ element }) => !element || !!document.querySelector(element));

    const driverObj = Driver({
        popoverClass: 'siia-driver-popover',
        stagePadding: 4,
        allowClose: true,
        steps: filteredSteps
    });

    if (KEY) {
        localStorage.setItem(KEY, '1'); // marcar como mostrado solo si hay userId válido
    }
    driverObj.drive();
});
