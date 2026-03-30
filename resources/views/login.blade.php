<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – International Sales Meeting 2026 | Mühlen Sohn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } } }
    </script>
    <style>
        canvas { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-950 text-white overflow-hidden h-screen">

    <!-- Particle Canvas -->
    <canvas id="particles"></canvas>

    <!-- Login Card -->
    <div class="relative z-10 flex flex-col items-center justify-center h-screen px-6">
        <div class="w-full max-w-sm">
            <!-- Logo -->
            <div class="absolute top-[15%] left-1/2 -translate-x-1/2 text-center">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Mühlen Sohn" class="h-[5rem] mx-auto brightness-0 invert opacity-90 mb-4">
                <h1 class="text-2xl font-bold text-white mb-2">International Sales Meeting 2026</h1>
            </div>

            <p class="text-sm text-gray-400 text-center mb-4">Please enter your access code</p>

            <!-- Code Input -->
            <form method="POST" action="{{ route('login.submit') }}" id="pin-form">
                @csrf
                <input type="hidden" name="pin" id="pin-hidden">

                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8">
                    @error('pin')
                        <p class="text-red-400 text-sm text-center mb-4">{{ $message }}</p>
                    @enderror

                    <div class="flex justify-center gap-3 mb-8" id="code-inputs">
                        <input type="text" maxlength="1" maxlength="1" autocapitalize="characters" autocomplete="off" class="code-digit w-12 h-14 text-center text-xl font-bold bg-white/10 border border-white/20 rounded-xl text-white uppercase focus:outline-none focus:border-green-400 focus:bg-white/15 transition caret-transparent" autofocus>
                        <input type="text" maxlength="1" maxlength="1" autocapitalize="characters" autocomplete="off" class="code-digit w-12 h-14 text-center text-xl font-bold bg-white/10 border border-white/20 rounded-xl text-white uppercase focus:outline-none focus:border-green-400 focus:bg-white/15 transition caret-transparent">
                        <input type="text" maxlength="1" maxlength="1" autocapitalize="characters" autocomplete="off" class="code-digit w-12 h-14 text-center text-xl font-bold bg-white/10 border border-white/20 rounded-xl text-white uppercase focus:outline-none focus:border-green-400 focus:bg-white/15 transition caret-transparent">
                        <input type="text" maxlength="1" maxlength="1" autocapitalize="characters" autocomplete="off" class="code-digit w-12 h-14 text-center text-xl font-bold bg-white/10 border border-white/20 rounded-xl text-white uppercase focus:outline-none focus:border-green-400 focus:bg-white/15 transition caret-transparent">
                        <input type="text" maxlength="1" maxlength="1" autocapitalize="characters" autocomplete="off" class="code-digit w-12 h-14 text-center text-xl font-bold bg-white/10 border border-white/20 rounded-xl text-white uppercase focus:outline-none focus:border-green-400 focus:bg-white/15 transition caret-transparent">
                        <input type="text" maxlength="1" maxlength="1" autocapitalize="characters" autocomplete="off" class="code-digit w-12 h-14 text-center text-xl font-bold bg-white/10 border border-white/20 rounded-xl text-white uppercase focus:outline-none focus:border-green-400 focus:bg-white/15 transition caret-transparent">
                    </div>

                    <button type="submit" id="login-btn" class="w-full py-3.5 bg-green-500/80 hover:bg-green-500 text-white font-medium rounded-xl transition text-sm backdrop-blur-sm">
                        Log in
                    </button>
                </div>
            </form>

            <p class="text-center text-xs text-gray-500 mt-6">
                You can find the access code in your invitation.
            </p>
        </div>
    </div>

    <!-- Particle Fabric Animation -->
    <script>
        const canvas = document.getElementById('particles');
        const ctx = canvas.getContext('2d');
        let nodes = [];
        let mouse = { x: null, y: null, radius: 200 };
        let time = 0;

        function resize() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            initNodes();
        }

        window.addEventListener('resize', resize);

        window.addEventListener('mousemove', e => {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        });
        window.addEventListener('mouseout', () => {
            mouse.x = null;
            mouse.y = null;
        });

        function initNodes() {
            nodes = [];
            const spacing = 40;
            const cols = Math.ceil(canvas.width / spacing) + 2;
            const rows = Math.ceil(canvas.height / spacing) + 2;
            const offsetX = (canvas.width - (cols - 1) * spacing) / 2;
            const offsetY = (canvas.height - (rows - 1) * spacing) / 2;

            for (let row = 0; row < rows; row++) {
                for (let col = 0; col < cols; col++) {
                    nodes.push({
                        homeX: offsetX + col * spacing,
                        homeY: offsetY + row * spacing,
                        x: offsetX + col * spacing,
                        y: offsetY + row * spacing,
                        z: 0,
                        col: col,
                        row: row,
                        phaseX: col * 0.3 + row * 0.15,
                        phaseY: row * 0.25 + col * 0.1,
                        phaseZ: col * 0.2 + row * 0.2,
                    });
                }
            }
        }

        function updateNodes() {
            time += 0.008;

            nodes.forEach(node => {
                const waveX = Math.sin(time * 1.2 + node.phaseX) * 8 +
                              Math.sin(time * 0.7 + node.phaseY * 1.5) * 5;
                const waveY = Math.cos(time * 0.9 + node.phaseY) * 6 +
                              Math.sin(time * 1.4 + node.phaseX * 0.8) * 4;
                const waveZ = Math.sin(time * 0.6 + node.phaseZ) * 30 +
                              Math.cos(time * 1.1 + node.phaseZ * 1.3) * 20;

                let targetX = node.homeX + waveX;
                let targetY = node.homeY + waveY;
                let targetZ = waveZ;

                if (mouse.x !== null && mouse.y !== null) {
                    const dx = node.homeX - mouse.x;
                    const dy = node.homeY - mouse.y;
                    const dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < mouse.radius) {
                        const force = (1 - dist / mouse.radius);
                        const power = force * force * 60;
                        targetX += (dx / dist) * power * 0.5;
                        targetY += (dy / dist) * power * 0.5;
                        targetZ += power * 1.5;
                    }
                }

                node.x += (targetX - node.x) * 0.08;
                node.y += (targetY - node.y) * 0.08;
                node.z += (targetZ - node.z) * 0.08;
            });
        }

        function getNodeIndex(col, row) {
            const cols = Math.ceil(canvas.width / 40) + 2;
            const rows = Math.ceil(canvas.height / 40) + 2;
            if (col < 0 || col >= cols || row < 0 || row >= rows) return -1;
            return row * cols + col;
        }

        function drawFabric() {
            const cols = Math.ceil(canvas.width / 40) + 2;

            nodes.forEach((node, i) => {
                const depthFactor = (node.z + 50) / 100;
                const brightness = Math.max(0.05, Math.min(0.6, depthFactor * 0.4 + 0.1));

                const rightIdx = getNodeIndex(node.col + 1, node.row);
                const bottomIdx = getNodeIndex(node.col, node.row + 1);
                const diagIdx = getNodeIndex(node.col + 1, node.row + 1);

                if (rightIdx >= 0 && rightIdx < nodes.length) {
                    const neighbor = nodes[rightIdx];
                    const avgZ = (node.z + neighbor.z) / 2;
                    const lineDepth = (avgZ + 50) / 100;
                    const opacity = Math.max(0.02, Math.min(0.18, lineDepth * 0.15 + 0.03));
                    ctx.beginPath();
                    ctx.moveTo(node.x, node.y);
                    ctx.lineTo(neighbor.x, neighbor.y);
                    ctx.strokeStyle = `rgba(14, 160, 57, ${opacity})`;
                    ctx.lineWidth = 0.6;
                    ctx.stroke();
                }

                if (bottomIdx >= 0 && bottomIdx < nodes.length) {
                    const neighbor = nodes[bottomIdx];
                    const avgZ = (node.z + neighbor.z) / 2;
                    const lineDepth = (avgZ + 50) / 100;
                    const opacity = Math.max(0.02, Math.min(0.18, lineDepth * 0.15 + 0.03));
                    ctx.beginPath();
                    ctx.moveTo(node.x, node.y);
                    ctx.lineTo(neighbor.x, neighbor.y);
                    ctx.strokeStyle = `rgba(14, 160, 57, ${opacity})`;
                    ctx.lineWidth = 0.6;
                    ctx.stroke();
                }

                if (diagIdx >= 0 && diagIdx < nodes.length) {
                    const neighbor = nodes[diagIdx];
                    const avgZ = (node.z + neighbor.z) / 2;
                    const lineDepth = (avgZ + 50) / 100;
                    const opacity = Math.max(0.01, Math.min(0.08, lineDepth * 0.06 + 0.01));
                    ctx.beginPath();
                    ctx.moveTo(node.x, node.y);
                    ctx.lineTo(neighbor.x, neighbor.y);
                    ctx.strokeStyle = `rgba(74, 222, 128, ${opacity})`;
                    ctx.lineWidth = 0.3;
                    ctx.stroke();
                }

                const dotSize = 0.8 + depthFactor * 1.5;

                if (brightness > 0.3) {
                    ctx.beginPath();
                    ctx.arc(node.x, node.y, dotSize + 3, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(14, 160, 57, ${brightness * 0.15})`;
                    ctx.fill();
                }

                ctx.beginPath();
                ctx.arc(node.x, node.y, dotSize, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(14, 160, 57, ${brightness})`;
                ctx.fill();
            });
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            updateNodes();
            drawFabric();
            requestAnimationFrame(animate);
        }

        resize();
        animate();

        // Code input logic
        const digits = document.querySelectorAll('.code-digit');
        const pinHidden = document.getElementById('pin-hidden');
        const pinForm = document.getElementById('pin-form');

        function updateHiddenPin() {
            pinHidden.value = Array.from(digits).map(d => d.value).join('');
        }

        digits.forEach((digit, index) => {
            digit.addEventListener('input', (e) => {
                const val = e.target.value;
                if (!/^[a-zA-Z0-9]$/.test(val)) {
                    e.target.value = '';
                    return;
                }
                e.target.value = val.toUpperCase();
                if (val && index < digits.length - 1) {
                    digits[index + 1].focus();
                }
                updateHiddenPin();
                // Auto-submit when all 6 fields are filled
                if (pinHidden.value.length === 6) {
                    pinForm.submit();
                }
            });

            digit.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace') {
                    if (!digit.value && index > 0) {
                        digits[index - 1].focus();
                        digits[index - 1].value = '';
                    }
                }
                if (e.key === 'Enter') {
                    updateHiddenPin();
                    pinForm.submit();
                }
                if (e.key === 'ArrowLeft' && index > 0) {
                    digits[index - 1].focus();
                }
                if (e.key === 'ArrowRight' && index < digits.length - 1) {
                    digits[index + 1].focus();
                }
            });

            digit.addEventListener('focus', () => {
                digit.select();
            });

            digit.addEventListener('paste', (e) => {
                e.preventDefault();
                const paste = e.clipboardData.getData('text').replace(/[^a-zA-Z0-9]/g, '').toUpperCase().slice(0, 6);
                paste.split('').forEach((char, i) => {
                    if (digits[index + i]) {
                        digits[index + i].value = char;
                    }
                });
                const nextIndex = Math.min(index + paste.length, digits.length - 1);
                digits[nextIndex].focus();
                updateHiddenPin();
                if (pinHidden.value.length === 6) {
                    pinForm.submit();
                }
            });
        });
    </script>

</body>
</html>
