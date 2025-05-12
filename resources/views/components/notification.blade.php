@if (session('success'))
<div class="alert-notification success" style="display: none;">
    <div class="content">
        <i class="mdi mdi-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    <button class="close-btn"><i class="mdi mdi-close"></i></button>
</div>
@endif

@if (session('warning'))
<div class="alert-notification warning" style="display: none;">
    <div class="content">
        <i class="mdi mdi-alert-circle"></i>
        <span>{{ session('warning') }}</span>
    </div>
    <button class="close-btn"><i class="mdi mdi-close"></i></button>
</div>
@endif

@if (session('error'))
<div class="alert-notification error" style="display: none;">
    <div class="content">
        <i class="mdi mdi-alert-circle"></i>
        <span>{{ session('error') }}</span>
    </div>
    <button class="close-btn"><i class="mdi mdi-close"></i></button>
</div>
@endif

<style>
.alert-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 20px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 450px;
    min-width: 300px;
    box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    z-index: 9999;
    animation: slideIn 0.5s ease, fadeOut 0.5s ease 4.5s forwards;
}

.alert-notification .content {
    display: flex;
    align-items: center;
}

.alert-notification i {
    margin-right: 10px;
    font-size: 24px;
}

.alert-notification.success {
    background-color: #4CAF50;
    color: white;
    border-left: 5px solid #388E3C;
}

.alert-notification.error {
    background-color: #F44336;
    color: white;
    border-left: 5px solid #D32F2F;
}

.alert-notification.warning {
    background-color: #F44336;
    color: white;
    border-left: 5px solid #D32F2F;
}

.alert-notification .close-btn {
    background: transparent;
    border: none;
    color: white;
    cursor: pointer;
    font-size: 18px;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
        visibility: hidden;
    }
}
</style>

<script>
// Wait for window load event to ensure loader is complete
window.addEventListener('load', function() {
    // Clear any existing notifications from previous pages
    const existingNotifications = document.querySelectorAll('.alert-notification');
    existingNotifications.forEach(notification => {
        notification.style.display = 'flex';

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            notification.remove();
        }, 5000);

        // Close button functionality
        const closeBtn = notification.querySelector('.close-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                notification.remove();
            });
        }
    });

    // Clear session flash messages after displaying them
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        fetch('/clear-flash-messages', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).catch(error => {
            console.error('Failed to clear flash messages:', error);
        });
    }
});
</script>





