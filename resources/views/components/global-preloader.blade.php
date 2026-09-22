<style>
    #global-preloader {
        position: fixed;
        inset: 0;
        z-index: 999999;
        background: transparent;
        pointer-events: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .dots-loader {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .dots-loader .dot {
        width: 14px;
        height: 14px;
        background-color: #2563eb;
        border-radius: 50%;
        display: inline-block;
        animation: dotPulse 1.2s infinite ease-in-out both;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.35);
    }

    .dots-loader .dot:nth-child(1) {
        animation-delay: -0.32s;
    }
    .dots-loader .dot:nth-child(2) {
        animation-delay: -0.16s;
    }
    .dots-loader .dot:nth-child(3) {
        animation-delay: 0s;
    }

    @keyframes dotPulse {
        0%, 80%, 100% {
            transform: scale(0.5);
            opacity: 0.3;
        }
        40% {
            transform: scale(1.2);
            opacity: 1;
        }
    }
</style>

<div id="global-preloader">
    <div class="dots-loader">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
</div>

<script>
    (function() {
        let isInitialLoad = true;

        function showPreloader() {
            const preloader = document.getElementById('global-preloader');
            if(preloader) {
                preloader.style.visibility = 'visible';
                preloader.style.opacity = '1';
            }
        }

        function hidePreloader(instant = false) {
            const preloader = document.getElementById('global-preloader');
            if(preloader) {
                if (instant) {
                    preloader.style.opacity = '0';
                    preloader.style.visibility = 'hidden';
                } else {
                    preloader.style.opacity = '0';
                    setTimeout(() => { preloader.style.visibility = 'hidden'; }, 300);
                }
            }
        }

        // Initial browser page load
        window.addEventListener('load', function() {
            setTimeout(() => {
                hidePreloader(false);
            }, 300);
        });

        // Navigation unload
        window.addEventListener('beforeunload', function() {
            showPreloader();
        });

        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                hidePreloader(true);
            }
        });

        // Hotwire Turbo navigation events
        document.addEventListener('turbo:request-start', function() {
            showPreloader();
        });

        document.addEventListener('turbo:load', function() {
            if (isInitialLoad) {
                isInitialLoad = false;
            } else {
                hidePreloader(true);
            }
        });
    })();
</script>
