/**
 * ADONIS CHEMICAL LIMITED - INTERACTIVE SCIENTIFIC & MOLECULAR HERO CANVAS
 * Advanced Canvas Physics Simulation with Molecular Bonds, Orbitals, and Hexagonal Rings.
 */

document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('chemical-canvas-hero');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width, height;
    let particles = [];
    let hexagons = [];
    let mouse = { x: null, y: null, radius: 150 };

    // Device performance tuning
    const isMobile = window.innerWidth < 768;
    const particleCount = isMobile ? 35 : 75;
    const maxBondDistance = isMobile ? 100 : 160;
    const hexagonCount = isMobile ? 3 : 7;

    function resize() {
        const parent = canvas.parentElement;
        width = canvas.width = parent.offsetWidth;
        height = canvas.height = parent.offsetHeight;
    }

    window.addEventListener('resize', resize);
    resize();

    // Mouse interactive tracking
    canvas.addEventListener('mousemove', (e) => {
        const rect = canvas.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
    });

    canvas.addEventListener('mouseleave', () => {
        mouse.x = null;
        mouse.y = null;
    });

    // Molecular Particle Class
    class Particle {
        constructor() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.vx = (Math.random() - 0.5) * 0.7;
            this.vy = (Math.random() - 0.5) * 0.7;
            this.radius = Math.random() * 3.5 + 2;
            this.baseRadius = this.radius;
            // Palette of rich scientific blues & cyans tailored for white hero (40% lower opacity for subtlety)
            const colors = [
                { r: 11, g: 94, b: 215, a: 0.42 },  // Corporate Blue #0B5ED7 (was 0.75)
                { r: 0, g: 183, b: 217, a: 0.46 },   // Cyan #00B7D9 (was 0.8)
                { r: 22, g: 140, b: 255, a: 0.42 }, // Scientific Blue #168CFF (was 0.75)
                { r: 7, g: 27, b: 51, a: 0.36 },    // Deep Navy #071B33 (was 0.65)
            ];
            this.color = colors[Math.floor(Math.random() * colors.length)];
            this.pulseSpeed = Math.random() * 0.03 + 0.01;
            this.pulseVal = Math.random() * Math.PI;
        }

        update() {
            this.pulseVal += this.pulseSpeed;
            this.radius = this.baseRadius + Math.sin(this.pulseVal) * 1.2;

            // Physics movement
            this.x += this.vx;
            this.y += this.vy;

            // Bounce at borders
            if (this.x < 0 || this.x > width) this.vx *= -1;
            if (this.y < 0 || this.y > height) this.vy *= -1;

            // Subtle mouse interaction
            if (mouse.x !== null && mouse.y !== null) {
                const dx = mouse.x - this.x;
                const dy = mouse.y - this.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < mouse.radius) {
                    const force = (mouse.radius - dist) / mouse.radius;
                    const dirX = dx / dist;
                    const dirY = dy / dist;
                    this.x -= dirX * force * 1.5;
                    this.y -= dirY * force * 1.5;
                }
            }
        }

        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, Math.max(1, this.radius), 0, Math.PI * 2);
            ctx.fillStyle = `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${this.color.a})`;
            ctx.shadowBlur = 4;
            ctx.shadowColor = `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, 0.18)`;
            ctx.fill();
            ctx.shadowBlur = 0; // reset
        }
    }

    // Hexagonal Chemical Ring Class (Benzene / Molecular structure)
    class HexagonStructure {
        constructor() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.size = Math.random() * 35 + 25;
            this.rotation = Math.random() * Math.PI;
            this.rotSpeed = (Math.random() - 0.5) * 0.005;
            this.vx = (Math.random() - 0.5) * 0.3;
            this.vy = (Math.random() - 0.5) * 0.3;
            this.opacity = Math.random() * 0.07 + 0.035; // 40% less opacity
        }

        update() {
            this.rotation += this.rotSpeed;
            this.x += this.vx;
            this.y += this.vy;

            if (this.x < -50) this.x = width + 50;
            if (this.x > width + 50) this.x = -50;
            if (this.y < -50) this.y = height + 50;
            if (this.y > height + 50) this.y = -50;
        }

        draw() {
            ctx.save();
            ctx.translate(this.x, this.y);
            ctx.rotate(this.rotation);
            ctx.beginPath();
            for (let i = 0; i < 6; i++) {
                const angle = (i * Math.PI) / 3;
                const hx = this.size * Math.cos(angle);
                const hy = this.size * Math.sin(angle);
                if (i === 0) ctx.moveTo(hx, hy);
                else ctx.lineTo(hx, hy);
            }
            ctx.closePath();
            ctx.strokeStyle = `rgba(11, 94, 215, ${this.opacity * 1.5})`;
            ctx.lineWidth = 1.0;
            ctx.stroke();

            // Inner circle
            ctx.beginPath();
            ctx.arc(0, 0, this.size * 0.55, 0, Math.PI * 2);
            ctx.strokeStyle = `rgba(0, 183, 217, ${this.opacity * 1.1})`;
            ctx.setLineDash([3, 3]);
            ctx.stroke();
            ctx.setLineDash([]);

            // Hexagon vertices nodes
            for (let i = 0; i < 6; i++) {
                const angle = (i * Math.PI) / 3;
                const hx = this.size * Math.cos(angle);
                const hy = this.size * Math.sin(angle);
                ctx.beginPath();
                ctx.arc(hx, hy, 1.8, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(11, 94, 215, ${this.opacity * 2.2})`;
                ctx.fill();
            }

            ctx.restore();
        }
    }

    // Initialize particles and hexagons
    for (let i = 0; i < particleCount; i++) {
        particles.push(new Particle());
    }

    for (let i = 0; i < hexagonCount; i++) {
        hexagons.push(new HexagonStructure());
    }

    // Draw connecting molecular bonds (40% less opacity)
    function drawBonds() {
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const p1 = particles[i];
                const p2 = particles[j];
                const dx = p1.x - p2.x;
                const dy = p1.y - p2.y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < maxBondDistance) {
                    const alpha = (1 - dist / maxBondDistance) * 0.13;
                    ctx.beginPath();
                    ctx.moveTo(p1.x, p1.y);
                    ctx.lineTo(p2.x, p2.y);
                    ctx.strokeStyle = `rgba(11, 94, 215, ${alpha})`;
                    ctx.lineWidth = 0.9;
                    ctx.stroke();
                }
            }
        }
    }

    // Main animation loop
    let animationFrameId;
    function animate() {
        ctx.clearRect(0, 0, width, height);

        // Render Hexagons first
        for (let h of hexagons) {
            h.update();
            h.draw();
        }

        // Render Molecular Bonds
        drawBonds();

        // Render Atoms/Particles
        for (let p of particles) {
            p.update();
            p.draw();
        }

        animationFrameId = requestAnimationFrame(animate);
    }

    animate();

    // Pause on page hidden for performance
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            cancelAnimationFrame(animationFrameId);
        } else {
            animate();
        }
    });
});
