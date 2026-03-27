<div id="toastContainer"></div>

<style>
    #toastContainer {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
    }

    .toast {
        background: white;
        padding: 16px 24px;
        margin-bottom: 10px;
        border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 300px;
        animation: slideIn 0.3s ease-in-out;
    }

    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .toast.success {
        border-left: 4px solid #388e3c;
    }

    .toast.success .icon {
        color: #388e3c;
        font-size: 20px;
    }

    .toast.error {
        border-left: 4px solid #d32f2f;
    }

    .toast.error .icon {
        color: #d32f2f;
        font-size: 20px;
    }

    .toast.warning {
        border-left: 4px solid #f57c00;
    }

    .toast.warning .icon {
        color: #f57c00;
        font-size: 20px;
    }

    .toast-content {
        flex: 1;
    }

    .toast-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 4px;
    }

    .toast-message {
        color: #666;
        font-size: 14px;
    }

    .toast-close {
        cursor: pointer;
        color: #999;
        font-size: 20px;
        line-height: 1;
    }

    .toast-close:hover {
        color: #333;
    }
</style>

<script>
    function showToast(message, type = 'info', title = '') {
        const container = document.getElementById('toastContainer');
        
        const toastElement = document.createElement('div');
        toastElement.className = `toast ${type}`;
        
        const iconMap = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        };
        
        const titleMap = {
            success: 'Berhasil',
            error: 'Gagal',
            warning: 'Peringatan',
            info: 'Informasi'
        };
        
        toastElement.innerHTML = `
            <span class="icon">${iconMap[type]}</span>
            <div class="toast-content">
                <div class="toast-title">${title || titleMap[type]}</div>
                <div class="toast-message">${message}</div>
            </div>
            <span class="toast-close">×</span>
        `;
        
        container.appendChild(toastElement);
        
        const closeBtn = toastElement.querySelector('.toast-close');
        closeBtn.addEventListener('click', () => {
            toastElement.remove();
        });
        
        // Auto-remove setelah 5 detik
        setTimeout(() => {
            if (toastElement.parentNode) {
                toastElement.remove();
            }
        }, 5000);
    }

    // Tampilkan notifikasi dari session
    @if(session('success'))
        showToast('{{ session('success') }}', 'success');
    @endif

    @if(session('error'))
        showToast('{{ session('error') }}', 'error');
    @endif

    @if(session('warning'))
        showToast('{{ session('warning') }}', 'warning');
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            showToast('{{ $error }}', 'error');
        @endforeach
    @endif
</script>
