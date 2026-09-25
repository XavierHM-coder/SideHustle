const toggle = document.querySelector('.nav-toggle');
const nav = document.querySelector('.site-nav');
if (toggle && nav) {
  toggle.addEventListener('click', () => {
    const open = nav.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', String(open));
  });
  nav.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      nav.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
    });
  });
}

function setupScene(scene) {
  const layers = [...scene.querySelectorAll('[data-depth]')];
  if (!layers.length) return;

  let targetX = 0;
  let targetY = 0;
  let currentX = 0;
  let currentY = 0;
  let active = false;

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const disabled = reduceMotion || window.innerWidth < 768;

  const setFromPointer = (event) => {
    const rect = scene.getBoundingClientRect();
    const px = (event.clientX - rect.left) / rect.width;
    const py = (event.clientY - rect.top) / rect.height;
    targetX = (px - 0.5) * 2;
    targetY = (py - 0.5) * 2;
  };

  scene.addEventListener('mouseenter', (e) => {
    if (disabled) return;
    active = true;
    setFromPointer(e);
  });

  scene.addEventListener('mousemove', (e) => {
    if (disabled) return;
    active = true;
    setFromPointer(e);
  });

  scene.addEventListener('mouseleave', () => {
    active = false;
    targetX = 0;
    targetY = 0;
  });

  const animate = () => {
    currentX += (targetX - currentX) * 0.09;
    currentY += (targetY - currentY) * 0.09;

    layers.forEach((layer) => {
      const depth = parseFloat(layer.dataset.depth || '0');
      const moveX = currentX * depth;
      const moveY = currentY * depth;
      const rotate = currentX * (depth * 0.18);
      const scale = active ? 1.01 : 1;
      layer.style.transform = `translate3d(${moveX}px, ${moveY}px, 0) rotate(${rotate}deg) scale(${scale})`;
    });

    requestAnimationFrame(animate);
  };
  animate();
}

document.querySelectorAll('[data-scene]').forEach(setupScene);
