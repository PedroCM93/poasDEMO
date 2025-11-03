    
    document.addEventListener("DOMContentLoaded", function(e) {
        document.getElementById("loginForm").addEventListener("submit", function(e) {
            //e.preventDefault();
            const username = document.getElementById("username");
            const password = document.getElementById("password");
            let valid = true;
            [username, password].forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add("is-invalid");
                    valid = false;
                } else {
                    input.classList.remove("is-invalid");
                }
            });
        });
    });

    
