let timeout;

        function logout() {
            alert("Your account has been logged out due to inactivity.");
            window.location.href = 'logout.php';
        }


        function resetTimeout() {
            clearTimeout(timeout);
            timeout = setTimeout(logout, 600000); // 5 Minutes
        }
        window.onload = resetTimeout;
        document.onmousemove = resetTimeout;
        document.onkeypress = resetTimeout;
        document.onclick = resetTimeout;
        