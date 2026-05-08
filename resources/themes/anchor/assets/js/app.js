window.demoButtonClickMessage = function(event){
    event.preventDefault(); new FilamentNotification().title('Modify this button in your theme folder').icon('heroicon-o-pencil-square').iconColor('info').send()
}

// Register service worker at root scope
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(reg => console.log('Theme Service Worker registered for scope:', reg.scope))
            .catch(err => console.log('Theme Service Worker registration error:', err));
    });
}