document.addEventListener('DOMContentLoaded', () => {

  /* =========================================================
     NAVBAR
  ========================================================= */

  const header = document.querySelector('.site-header');
  const toggle = document.querySelector('.nav-toggle');
  const nav = document.querySelector('.site-nav');

  // Mobile menu
  if (toggle && nav) {

    toggle.addEventListener('click', () => {

      const open = nav.classList.toggle('is-open');

      toggle.setAttribute(
        'aria-expanded',
        String(open)
      );

    });

    nav.querySelectorAll('a').forEach(link => {

      link.addEventListener('click', () => {

        nav.classList.remove('is-open');

        toggle.setAttribute(
          'aria-expanded',
          'false'
        );

      });

    });

  }


  /* =========================================================
     NAVBAR SHRINK ON SCROLL
  ========================================================= */

  if (header) {

    const updateNavbar = () => {

      if (window.scrollY > 60) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }

    };

    window.addEventListener(
      'scroll',
      updateNavbar,
      { passive: true }
    );

    updateNavbar();

  }


  /* =========================================================
     3D GRAFFITI BACKGROUND
  ========================================================= */

  const graffitiContainer =
    document.querySelector('.graffiti-bg');

  if (graffitiContainer) {

    const reduceMotion =
      window.matchMedia(
        '(prefers-reduced-motion: reduce)'
      ).matches;


    /* ---------------------------------------------------------
       CONFIGURACIÓN
    --------------------------------------------------------- */

    const graffitiConfig = [

      {
        file: 'grafiti1.png',
        x: 4,
        y: 13,
        size: 210,
        rotate: -12,
        depth: 18,
        thickness: 8,
        drift: 0.018,
        float: 0.8
      },

      {
        file: 'grafiti2.png',
        x: 76,
        y: 8,
        size: 180,
        rotate: 14,
        depth: 32,
        thickness: 10,
        drift: -0.012,
        float: 1.1
      },

      {
        file: 'grafiti3.png',
        x: 67,
        y: 36,
        size: 230,
        rotate: -7,
        depth: 46,
        thickness: 12,
        drift: 0.022,
        float: 0.7
      },

      {
        file: 'grafiti4.png',
        x: 2,
        y: 49,
        size: 175,
        rotate: 8,
        depth: 24,
        thickness: 7,
        drift: -0.018,
        float: 1.3
      },

      {
        file: 'grafiti5.png',
        x: 82,
        y: 59,
        size: 200,
        rotate: -15,
        depth: 54,
        thickness: 13,
        drift: 0.015,
        float: 0.9
      },

      {
        file: 'grafiti6.png',
        x: 29,
        y: 72,
        size: 190,
        rotate: 10,
        depth: 34,
        thickness: 9,
        drift: -0.02,
        float: 1.2
      },

      {
        file: 'grafiti7.png',
        x: 54,
        y: 84,
        size: 160,
        rotate: -5,
        depth: 62,
        thickness: 14,
        drift: 0.012,
        float: 0.75
      }

    ];


    const graffitiElements = [];


    /* =========================================================
       CREAR CADA GRAFFITI
    ========================================================= */

    graffitiConfig.forEach((config) => {

      const wrapper =
        document.createElement('div');

      wrapper.className =
        'graffiti-3d';


      wrapper.style.width =
        `${config.size}px`;

      wrapper.style.left =
        `${config.x}%`;

      wrapper.style.top =
        `${config.y}%`;


      /*
       * Contenedor interno
       */

      const scene =
        document.createElement('div');

      scene.className =
        'graffiti-depth';


      /* -------------------------------------------------------
         EXTRUSIÓN
      ------------------------------------------------------- */

      const extrusion =
        document.createElement('div');

      extrusion.className =
        'graffiti-extrusion';


      /*
       * Creamos varias copias del PNG.
       * Cada copia se desplaza ligeramente hacia atrás.
       * Esto genera el efecto de volumen.
       */

      const extrusionLayers = [];

      const layers =
        Math.max(4, config.thickness);


      for (let i = layers; i >= 1; i--) {

        const layer =
          document.createElement('img');

        layer.src =
          `assets/img/${config.file}`;

        layer.alt = '';

        layer.draggable = false;

        layer.className =
          'graffiti-layer';


        const offset =
          i * 1.25;


        layer.style.transform =
          `
          translate(
            ${offset}px,
            ${offset}px
          )
          `;


        /*
         * Las capas posteriores son más oscuras.
         */

        layer.style.opacity =
          `${0.16 + (1 - i / layers) * 0.18}`;


        layer.style.filter =
          `
          brightness(0.22)
          saturate(0.65)
          `;


        extrusion.appendChild(layer);

        extrusionLayers.push(layer);

      }


      /* -------------------------------------------------------
         IMAGEN PRINCIPAL
      ------------------------------------------------------- */

      const front =
        document.createElement('img');

      front.src =
        `assets/img/${config.file}`;

      front.alt = '';

      front.draggable = false;

      front.className =
        'graffiti-front';


      /* -------------------------------------------------------
         HIGHLIGHT
      ------------------------------------------------------- */

      const highlight =
        document.createElement('img');

      highlight.src =
        `assets/img/${config.file}`;

      highlight.alt = '';

      highlight.draggable = false;

      highlight.className =
        'graffiti-highlight';


      scene.appendChild(extrusion);

      scene.appendChild(front);

      scene.appendChild(highlight);

      wrapper.appendChild(scene);

      graffitiContainer.appendChild(wrapper);


      /* -------------------------------------------------------
         ESTADO
      ------------------------------------------------------- */

      graffitiElements.push({

        element: wrapper,

        scene,

        front,

        highlight,

        extrusionLayers,

        config,

        currentX: 0,
        currentY: 0,

        targetX: 0,
        targetY: 0,

        currentRotateX: 0,
        currentRotateY: 0,

        targetRotateX: 0,
        targetRotateY: 0,

        currentScale: 1,
        targetScale: 1,

        currentZ: 0,
        targetZ: 0,

        phase:
          Math.random() * Math.PI * 2

      });

    });


    /* =========================================================
       MOUSE
    ========================================================= */

    let mouseX = 0;
    let mouseY = 0;


    if (!reduceMotion) {

      window.addEventListener(
        'mousemove',
        (event) => {

          mouseX =
            (
              event.clientX /
              window.innerWidth -
              0.5
            ) * 2;


          mouseY =
            (
              event.clientY /
              window.innerHeight -
              0.5
            ) * 2;

        },
        { passive: true }
      );

    }


    /* =========================================================
       ANIMACIÓN
    ========================================================= */

    const animateGraffiti = (time) => {

      const seconds =
        time * 0.001;

      const scroll =
        window.scrollY;


      graffitiElements.forEach((item) => {

        const config =
          item.config;


        /* -----------------------------------------------------
           MOVIMIENTO DEL MOUSE
        ----------------------------------------------------- */

        if (reduceMotion) {

          item.targetX = 0;
          item.targetY = 0;

          item.targetRotateX = 0;
          item.targetRotateY = 0;

          item.targetScale = 1;

          item.targetZ = config.depth;

        } else {

          /*
           * Movimiento horizontal y vertical.
           */

          item.targetX =
            mouseX * config.depth;


          item.targetY =
            mouseY * config.depth;


          /*
           * Rotación X/Y.
           */

          item.targetRotateY =
            mouseX *
            (config.depth * 0.16);


          item.targetRotateX =
            -mouseY *
            (config.depth * 0.11);


          /*
           * Acercamiento.
           */

          const distance =
            Math.sqrt(
              mouseX * mouseX +
              mouseY * mouseY
            );


          item.targetScale =
            1 +
            Math.min(
              distance * 0.025,
              0.035
            );


          /*
           * Profundidad real del objeto.
           */

          item.targetZ =
            config.depth +
            mouseY * 10;

        }


        /* -----------------------------------------------------
           SMOOTH POSITION
        ----------------------------------------------------- */

        item.currentX +=
          (
            item.targetX -
            item.currentX
          ) * 0.035;


        item.currentY +=
          (
            item.targetY -
            item.currentY
          ) * 0.035;


        /* -----------------------------------------------------
           SMOOTH ROTATION
        ----------------------------------------------------- */

        item.currentRotateX +=
          (
            item.targetRotateX -
            item.currentRotateX
          ) * 0.035;


        item.currentRotateY +=
          (
            item.targetRotateY -
            item.currentRotateY
          ) * 0.035;


        /* -----------------------------------------------------
           SMOOTH SCALE
        ----------------------------------------------------- */

        item.currentScale +=
          (
            item.targetScale -
            item.currentScale
          ) * 0.035;


        /* -----------------------------------------------------
           SMOOTH Z
        ----------------------------------------------------- */

        item.currentZ +=
          (
            item.targetZ -
            item.currentZ
          ) * 0.035;


        /* -----------------------------------------------------
           FLOAT
        ----------------------------------------------------- */

        const floating =
          Math.sin(
            seconds *
            config.float +
            item.phase
          ) * 4;


        /* -----------------------------------------------------
           SCROLL
        ----------------------------------------------------- */

        const scrollOffset =
          scroll *
          config.drift;


        const finalY =
          item.currentY +
          floating +
          scrollOffset;


        /* =====================================================
           TRANSFORMACIÓN 3D
        ===================================================== */

        item.element.style.transform =
          `
          translate3d(
            ${item.currentX}px,
            ${finalY}px,
            ${item.currentZ}px
          )

          rotateX(
            ${item.currentRotateX}deg
          )

          rotateY(
            ${item.currentRotateY}deg
          )

          rotateZ(
            ${config.rotate}deg
          )

          scale(
            ${item.currentScale}
          )
          `;


        /* -----------------------------------------------------
           PARALLAX DE LA EXTRUSIÓN
        ----------------------------------------------------- */

        const extrusionShift =
          1 +
          Math.abs(item.currentRotateX) * 0.035 +
          Math.abs(item.currentRotateY) * 0.035;


        item.extrusionLayers.forEach(
          (layer, index) => {

            const offset =
              (
                item.extrusionLayers.length -
                index
              ) *
              extrusionShift;


            layer.style.transform =
              `
              translate(
                ${offset}px,
                ${offset}px
              )
              `;

          }
        );


        /* -----------------------------------------------------
           HIGHLIGHT
        ----------------------------------------------------- */

        item.highlight.style.transform =
          `
          translate(
            ${-item.currentRotateY * 0.035}px,
            ${-item.currentRotateX * 0.035}px
          )
          `;

      });


      requestAnimationFrame(
        animateGraffiti
      );

    };


    requestAnimationFrame(
      animateGraffiti
    );

  }


  /* =========================================================
     PARALLAX SCENES
  ========================================================= */

  function setupScene(scene) {

    const layers =
      [
        ...scene.querySelectorAll(
          '[data-depth]'
        )
      ];


    if (!layers.length) return;


    let targetX = 0;
    let targetY = 0;

    let currentX = 0;
    let currentY = 0;

    let active = false;


    const reduceMotion =
      window.matchMedia(
        '(prefers-reduced-motion: reduce)'
      ).matches;


    const disabled =
      reduceMotion ||
      window.innerWidth < 768;


    const setFromPointer =
      (event) => {

        const rect =
          scene.getBoundingClientRect();


        const px =
          (
            event.clientX -
            rect.left
          ) /
          rect.width;


        const py =
          (
            event.clientY -
            rect.top
          ) /
          rect.height;


        targetX =
          (px - 0.5) * 2;


        targetY =
          (py - 0.5) * 2;

      };


    scene.addEventListener(
      'mouseenter',
      (event) => {

        if (disabled) return;

        active = true;

        setFromPointer(event);

      }
    );


    scene.addEventListener(
      'mousemove',
      (event) => {

        if (disabled) return;

        active = true;

        setFromPointer(event);

      }
    );


    scene.addEventListener(
      'mouseleave',
      () => {

        active = false;

        targetX = 0;
        targetY = 0;

      }
    );


    const animate = () => {

      currentX +=
        (
          targetX -
          currentX
        ) * 0.09;


      currentY +=
        (
          targetY -
          currentY
        ) * 0.09;


      layers.forEach((layer) => {

        const depth =
          parseFloat(
            layer.dataset.depth || '0'
          );


        const moveX =
          currentX *
          depth;


        const moveY =
          currentY *
          depth;


        const rotate =
          currentX *
          (depth * 0.18);


        const scale =
          active
            ? 1.01
            : 1;


        layer.style.transform =
          `
          translate3d(
            ${moveX}px,
            ${moveY}px,
            0
          )

          rotate(
            ${rotate}deg
          )

          scale(
            ${scale}
          )
          `;

      });


      requestAnimationFrame(
        animate
      );

    };


    animate();

  }


  document
    .querySelectorAll('[data-scene]')
    .forEach(setupScene);


});