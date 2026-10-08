
  /* Toggle password */
  const eyeOpen = `<path stroke-linecap="round" stroke-linejoin="round" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
  const eyeOff  = `<path stroke-linecap="round" d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19M1 1l22 22"/><circle cx="12" cy="12" r="3"/>`;
  const pwd = document.getElementById('password');
  const ico = document.getElementById('eyeIco');
  document.getElementById('eyeBtn').addEventListener('click', () => {
    const show = pwd.type === 'password';
    pwd.type = show ? 'text' : 'password';
    ico.innerHTML = show ? eyeOff : eyeOpen;
  });

  /* Ripple */
  const btn = document.getElementById('btn');
  btn.addEventListener('click', function(e) {
    const rc = this.getBoundingClientRect();
    const s = document.createElement('span');
    s.className = 'ripple';
    const sz = this.offsetWidth * 2;
    s.style.cssText = `width:${sz}px;height:${sz}px;left:${e.clientX-rc.left-sz/2}px;top:${e.clientY-rc.top-sz/2}px`;
    this.appendChild(s);
    setTimeout(() => s.remove(), 700);
  });



  /* Parallax logos au mouvement souris */
  document.addEventListener('mousemove', e => {
    const cx = innerWidth / 2, cy = innerHeight / 2;
    const dx = (e.clientX - cx) / cx;
    const dy = (e.clientY - cy) / cy;
    document.querySelectorAll('.logo-3d').forEach((el, i) => {
      const d = ((i % 4) + 1) * 7;
      el.style.marginLeft = `${dx * d}px`;
      el.style.marginTop  = `${dy * d}px`;
    });
  });
