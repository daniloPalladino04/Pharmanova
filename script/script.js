document.addEventListener('DOMContentLoaded', function() {
    const signUpButton = document.getElementById('signUpButton');
    const signInButton = document.getElementById('signInButton');
    const signInForm = document.getElementById('signIn');
    const signUpForm = document.getElementById('signup');

    if (signUpButton && signInButton && signInForm && signUpForm) {
        signUpButton.addEventListener('click', function() {
            signInForm.style.display = "none";
            signUpForm.style.display = "block";
        });

        signInButton.addEventListener('click', function() {
            signInForm.style.display = "block";
            signUpForm.style.display = "none";
        });
    }

  
    const accountButtonContainer = document.getElementById('account-button-container');
    if (isLoggedIn) {
        accountButtonContainer.innerHTML = `
            <div class='dropdown'>
                <button id='link_area_riservata' class='initial'>
                    <span>${initialFn}</span><span>${initialLn}</span>
                </button>
                <div class='dropdown-content'>
                    <a href='logout.php'>Logout</a>
                </div>
            </div>
        `;

        const dropdownButton = document.getElementById('link_area_riservata');
        const dropdownContent = document.querySelector('.dropdown-content');

        dropdownButton.addEventListener('click', function(event) {
            event.stopPropagation();
            dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function(event) {
            if (!dropdownButton.contains(event.target)) {
                dropdownContent.style.display = 'none';
            }
        });
    } else {
        accountButtonContainer.innerHTML = `
            <form action='scelta_login.php'>
                <button id='link_area_riservata'>
                    <span class='material-symbols-outlined'>account_circle</span>
                </button>
            </form>
        `;
    }
});