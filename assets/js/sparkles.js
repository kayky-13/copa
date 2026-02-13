(() => {
  const canvas = document.createElement("canvas");
  const ctx = canvas.getContext("2d");
  canvas.className = "sparkle-canvas";
  document.body.appendChild(canvas);

  const particles = [];
  let w = 0;
  let h = 0;
  let lastTime = 0;

  const resize = () => {
    w = canvas.width = window.innerWidth;
    h = canvas.height = window.innerHeight;
  };

  const spawn = (x, y, count = 3) => {
    for (let i = 0; i < count; i++) {
      particles.push({
        x,
        y,
        vx: (Math.random() - 0.5) * 0.8,
        vy: (Math.random() - 0.8) * 1.2,
        life: 0,
        ttl: 120 + Math.random() * 60,
        size: 1 + Math.random() * 2.5,
        hue: 190 + Math.random() * 80
      });
    }
  };

  const step = (time) => {
    const dt = time - lastTime;
    lastTime = time;
    ctx.clearRect(0, 0, w, h);

    for (let i = particles.length - 1; i >= 0; i--) {
      const p = particles[i];
      p.life += dt * 0.06;
      p.x += p.vx * dt * 0.06;
      p.y += p.vy * dt * 0.06;
      p.vy += 0.002 * dt;

      const alpha = Math.max(0, 1 - p.life / p.ttl);
      ctx.beginPath();
      ctx.fillStyle = `hsla(${p.hue}, 100%, 70%, ${alpha})`;
      ctx.shadowColor = `hsla(${p.hue}, 100%, 70%, ${alpha})`;
      ctx.shadowBlur = 12;
      ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
      ctx.fill();

      if (p.life >= p.ttl) {
        particles.splice(i, 1);
      }
    }

    if (Math.random() < 0.35) {
      spawn(Math.random() * w, Math.random() * h * 0.8, 1);
    }

    requestAnimationFrame(step);
  };

  window.addEventListener("resize", resize);
  window.addEventListener("mousemove", (e) => {
    spawn(e.clientX, e.clientY, 4);
  });

  resize();
  requestAnimationFrame(step);
})();