@extends('layouts.app')

@section('title', 'Products Catalogue | Adonis Chemical Industries Ltd')
@section('meta_description', 'Browse the official SINODA products catalogue and technical chemical specifications by Adonis Chemical Industries Ltd.')

@section('content')

    <!-- Page Banner -->
    <section class="bg-slate-100 py-12 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs text-slate-500 mb-2">
                        <a href="{{ route('home') }}" class="hover:text-blue-700">Home</a>
                        <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        <span class="text-blue-700 font-semibold">Products Catalogue</span>
                    </div>
                    <h1 class="font-heading font-extrabold text-3xl sm:text-4xl text-navy">
                        {{ \App\Models\Setting::get('catalogue_title', 'Products Catalogue') }}
                    </h1>
                    <p class="text-sm text-slate-600 mt-1 max-w-2xl">
                        {{ \App\Models\Setting::get('catalogue_subtitle', 'Browse our official product catalogue and chemical formulations page-by-page. Use the previous/next buttons or swipe on mobile.') }}
                    </p>
                </div>
                <div>
                    <a href="{{ asset('storage/' . \App\Models\Setting::get('catalogue_pdf', 'catalogue/sinoda-product-catalogue-2026.pdf')) }}" download="SINODA_Product_Catalogue_2026.pdf" class="btn-corporate-red">
                        <i class="fa-solid fa-download"></i>
                        <span>Download Full PDF</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- PDF Reader Section -->
    <section class="py-14 bg-slate-50 min-h-[70vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- PDF Viewer Card -->
            <div class="max-w-4xl mx-auto bg-white rounded-xl border border-slate-300 shadow-lg p-4 sm:p-6">
                
                <!-- Toolbar -->
                <div class="flex flex-wrap items-center justify-between gap-3 pb-4 mb-4 border-b border-slate-200 text-xs">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1.5 rounded-md bg-blue-50 text-blue-800 font-bold border border-blue-200">
                            <i class="fa-solid fa-book-open mr-1"></i> Page <strong id="pdf-current-page" class="text-navy text-sm">1</strong> of <strong id="pdf-total-pages" class="text-navy text-sm">--</strong>
                        </span>
                        <span class="text-slate-500 hidden sm:inline text-[11px]">
                            <i class="fa-solid fa-hand-pointer text-blue-600 mr-1"></i> Click buttons or swipe left/right to change page
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <button id="pdf-zoom-out" class="p-2 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200" title="Zoom Out">
                            <i class="fa-solid fa-magnifying-glass-minus"></i>
                        </button>
                        <button id="pdf-zoom-in" class="p-2 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200" title="Zoom In">
                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                        </button>
                        <button id="pdf-fullscreen" class="p-2 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200" title="Fullscreen">
                            <i class="fa-solid fa-expand"></i>
                        </button>
                        <a href="{{ asset('storage/' . \App\Models\Setting::get('catalogue_pdf', 'catalogue/sinoda-product-catalogue-2026.pdf')) }}" download="SINODA_Product_Catalogue_2026.pdf" class="btn-corporate-red !py-2 !px-3.5 text-xs">
                            <i class="fa-solid fa-download"></i> Download PDF
                        </a>
                    </div>
                </div>

                <!-- PDF Slide Container -->
                <div class="relative flex items-center justify-center min-h-[440px] sm:min-h-[620px] bg-slate-100 rounded-lg p-2 sm:p-4 overflow-hidden border border-slate-200" id="pdf-viewer-container">
                    
                    <!-- Prev Button -->
                    <button id="pdf-prev-btn" class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white hover:bg-blue-600 text-navy hover:text-white shadow-md border border-slate-300 flex items-center justify-center text-base sm:text-lg transition disabled:opacity-30 disabled:pointer-events-none cursor-pointer" aria-label="Previous Page">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    <!-- Center Active Canvas Wrapper -->
                    <div class="relative z-10 flex flex-col items-center justify-center w-full">
                        <div id="pdf-loading-indicator" class="flex flex-col items-center justify-center py-24 space-y-2">
                            <div class="w-10 h-10 rounded-full border-3 border-blue-600 border-t-transparent animate-spin"></div>
                            <p class="text-xs font-bold text-slate-700">Loading Product Catalogue...</p>
                        </div>

                        <div id="pdf-canvas-wrapper" class="relative bg-white rounded-md shadow-md border border-slate-300 hidden cursor-grab active:cursor-grabbing transition duration-300">
                            <canvas id="pdf-render-canvas" class="max-w-full h-auto block rounded-md"></canvas>
                        </div>
                    </div>

                    <!-- Next Button -->
                    <button id="pdf-next-btn" class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white hover:bg-blue-600 text-navy hover:text-white shadow-md border border-slate-300 flex items-center justify-center text-base sm:text-lg transition disabled:opacity-30 disabled:pointer-events-none cursor-pointer" aria-label="Next Page">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>

                <!-- Bottom Dots Indicator -->
                <div class="mt-4 pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                    <div id="pdf-dots-container" class="flex items-center gap-1.5 overflow-x-auto max-w-full py-1">
                        <!-- Dots generated via JS -->
                    </div>
                    <div class="text-slate-500 text-[11px]">
                        Need custom bulk formulations? <a href="{{ route('contact') }}" class="text-blue-700 font-bold underline">Contact our Savar lab</a>
                    </div>
                </div>

            </div>

            <!-- Inquiries Callout -->
            <div class="max-w-4xl mx-auto mt-10 p-6 rounded-xl bg-white border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="font-heading font-bold text-base text-navy">Interested in Commercial Supply or Distributorship?</h3>
                    <p class="text-xs text-slate-600 mt-1">Our technical formulation team provides sample batches and custom formulation services from our Savar plant.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('products.index') }}" class="btn-corporate-outline text-xs">Browse Products</a>
                    <a href="{{ route('contact') }}" class="btn-corporate-primary text-xs">Inquire Now</a>
                </div>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
    <!-- PDF.js Flipbook & Page Slider Script -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const pdfUrl = "{{ asset('storage/' . \App\Models\Setting::get('catalogue_pdf', 'catalogue/sinoda-product-catalogue-2026.pdf')) }}";
        const canvas = document.getElementById('pdf-render-canvas');
        const wrapper = document.getElementById('pdf-canvas-wrapper');
        const loadingEl = document.getElementById('pdf-loading-indicator');
        const prevBtn = document.getElementById('pdf-prev-btn');
        const nextBtn = document.getElementById('pdf-next-btn');
        const currentPageEl = document.getElementById('pdf-current-page');
        const totalPagesEl = document.getElementById('pdf-total-pages');
        const dotsContainer = document.getElementById('pdf-dots-container');
        const zoomInBtn = document.getElementById('pdf-zoom-in');
        const zoomOutBtn = document.getElementById('pdf-zoom-out');
        const fullscreenBtn = document.getElementById('pdf-fullscreen');
        const viewerContainer = document.getElementById('pdf-viewer-container');

        if (!canvas || !pdfUrl || typeof pdfjsLib === 'undefined') return;

        let pdfDoc = null;
        let pageNum = 1;
        let pageRendering = false;
        let pageNumPending = null;
        let scale = 1.25;
        const ctx = canvas.getContext('2d');

        // Load PDF Document
        pdfjsLib.getDocument(pdfUrl).promise.then((pdfDoc_) => {
            pdfDoc = pdfDoc_;
            if (totalPagesEl) totalPagesEl.textContent = pdfDoc.numPages;

            // Render initial page
            renderPage(pageNum);

            // Generate Page Dot Buttons
            generateDots(pdfDoc.numPages);
        }).catch(err => {
            console.error('Error loading PDF catalogue:', err);
            if (loadingEl) {
                loadingEl.innerHTML = `
                    <div class="text-center p-6 space-y-2">
                        <i class="fa-solid fa-file-pdf text-3xl text-red-600 mb-2"></i>
                        <p class="font-bold text-navy text-sm">Official SINODA Product Catalogue</p>
                        <p class="text-xs text-slate-500">The technical specification catalogue is ready for direct download.</p>
                        <a href="${pdfUrl}" download class="btn-corporate-red text-xs !py-2 !px-4 mt-2 inline-flex">
                            <i class="fa-solid fa-download mr-1"></i> Download PDF Directly
                        </a>
                    </div>
                `;
            }
        });

        function renderPage(num, direction = null) {
            pageRendering = true;

            if (direction && wrapper) {
                wrapper.style.opacity = '0.3';
                wrapper.style.transform = 'scale(0.98)';
            }

            const animationDelay = direction ? 150 : 0;

            setTimeout(() => {
                pdfDoc.getPage(num).then(page => {
                    const isMobile = window.innerWidth < 640;
                    const containerWidth = viewerContainer.clientWidth || 600;
                    const viewportRaw = page.getViewport({ scale: 1 });
                    
                    // Responsive dynamic scaling for sharp rendering
                    const baseScale = Math.min((containerWidth - (isMobile ? 16 : 48)) / viewportRaw.width, 1.35);
                    const finalScale = baseScale * scale;
                    const viewport = page.getViewport({ scale: finalScale });
                    const outputScale = window.devicePixelRatio || 1;

                    canvas.width = Math.floor(viewport.width * outputScale);
                    canvas.height = Math.floor(viewport.height * outputScale);
                    canvas.style.width = Math.floor(viewport.width) + "px";
                    canvas.style.height = Math.floor(viewport.height) + "px";

                    const transform = outputScale !== 1 ? [outputScale, 0, 0, outputScale, 0, 0] : null;

                    const renderContext = {
                        canvasContext: ctx,
                        transform: transform,
                        viewport: viewport
                    };

                    const renderTask = page.render(renderContext);

                    renderTask.promise.then(() => {
                        pageRendering = false;
                        if (loadingEl) loadingEl.classList.add('hidden');
                        if (wrapper) {
                            wrapper.classList.remove('hidden');
                            wrapper.style.opacity = '1';
                            wrapper.style.transform = 'scale(1)';
                        }

                        if (pageNumPending !== null) {
                            renderPage(pageNumPending);
                            pageNumPending = null;
                        }

                        updateUI();
                    });
                });
            }, animationDelay);
        }

        function queueRenderPage(num, direction = null) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num, direction);
            }
        }

        function onPrevPage() {
            if (pageNum <= 1) return;
            pageNum--;
            queueRenderPage(pageNum, 'prev');
        }

        function onNextPage() {
            if (!pdfDoc || pageNum >= pdfDoc.numPages) return;
            pageNum++;
            queueRenderPage(pageNum, 'next');
        }

        function updateUI() {
            if (currentPageEl) currentPageEl.textContent = pageNum;
            if (prevBtn) prevBtn.disabled = (pageNum <= 1);
            if (nextBtn && pdfDoc) nextBtn.disabled = (pageNum >= pdfDoc.numPages);

            // Update active dot
            const dots = document.querySelectorAll('.pdf-page-dot');
            dots.forEach((dot, idx) => {
                if (idx + 1 === pageNum) {
                    dot.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
                    dot.classList.remove('bg-white', 'text-slate-700', 'border-slate-300');
                } else {
                    dot.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                    dot.classList.add('bg-white', 'text-slate-700', 'border-slate-300');
                }
            });
        }

        function generateDots(total) {
            if (!dotsContainer) return;
            dotsContainer.innerHTML = '';
            for (let i = 1; i <= total; i++) {
                const btn = document.createElement('button');
                btn.className = `pdf-page-dot px-2.5 py-1 text-xs font-bold rounded border transition ${i === 1 ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-700 border-slate-300 hover:bg-slate-100'}`;
                btn.textContent = i;
                btn.title = `Go to Page ${i}`;
                btn.addEventListener('click', () => {
                    if (i !== pageNum) {
                        const dir = i > pageNum ? 'next' : 'prev';
                        pageNum = i;
                        queueRenderPage(pageNum, dir);
                    }
                });
                dotsContainer.appendChild(btn);
            }
        }

        // Button Listeners
        if (prevBtn) prevBtn.addEventListener('click', onPrevPage);
        if (nextBtn) nextBtn.addEventListener('click', onNextPage);

        // Zoom Controls
        if (zoomInBtn) {
            zoomInBtn.addEventListener('click', () => {
                if (scale < 1.8) {
                    scale += 0.15;
                    queueRenderPage(pageNum);
                }
            });
        }
        if (zoomOutBtn) {
            zoomOutBtn.addEventListener('click', () => {
                if (scale > 0.8) {
                    scale -= 0.15;
                    queueRenderPage(pageNum);
                }
            });
        }

        // Fullscreen Toggle
        if (fullscreenBtn && viewerContainer) {
            fullscreenBtn.addEventListener('click', () => {
                if (!document.fullscreenElement) {
                    viewerContainer.requestFullscreen().catch(err => console.error(err));
                } else {
                    document.exitFullscreen();
                }
            });
        }

        // Touch Swipe Gesture Support
        let touchStartX = 0;
        let touchStartY = 0;
        let touchEndX = 0;
        let touchEndY = 0;

        if (viewerContainer) {
            viewerContainer.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
                touchStartY = e.changedTouches[0].screenY;
            }, { passive: true });

            viewerContainer.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                touchEndY = e.changedTouches[0].screenY;
                handleSwipe();
            }, { passive: true });

            // Mouse Drag Swipe Support for Desktops
            let isMouseDown = false;
            let mouseStartX = 0;

            viewerContainer.addEventListener('mousedown', (e) => {
                if (e.target.closest('button') || e.target.closest('a')) return;
                isMouseDown = true;
                mouseStartX = e.clientX;
            });

            viewerContainer.addEventListener('mouseup', (e) => {
                if (!isMouseDown) return;
                isMouseDown = false;
                const mouseEndX = e.clientX;
                const diffX = mouseEndX - mouseStartX;
                if (Math.abs(diffX) > 50) {
                    if (diffX < -50) onNextPage();
                    else if (diffX > 50) onPrevPage();
                }
            });

            viewerContainer.addEventListener('mouseleave', () => {
                isMouseDown = false;
            });
        }

        function handleSwipe() {
            const diffX = touchEndX - touchStartX;
            const diffY = touchEndY - touchStartY;
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 40) {
                if (diffX < 0) {
                    onNextPage();
                } else {
                    onPrevPage();
                }
            }
        }

        // Keyboard Arrow Navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                onPrevPage();
            } else if (e.key === 'ArrowRight') {
                onNextPage();
            }
        });

        // Window resize handler
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                if (pdfDoc) renderPage(pageNum);
            }, 200);
        });
    });
    </script>
@endpush
