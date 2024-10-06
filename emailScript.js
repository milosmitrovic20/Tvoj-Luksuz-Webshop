document.addEventListener('DOMContentLoaded', () => {
    const emailForm = document.getElementById('emailForm');
    const submitBtn = document.querySelector('.search-btn'); // Target the <a> tag

    submitBtn.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default action of the <a> tag
        
        const emailInput = document.getElementById('email').value;

        if (!validateEmail(emailInput)) {
            alert('Please enter a valid email address.');
            return;
        }

        // Send the email to the server using fetch API
        fetch('submit_email.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email: emailInput })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Email successfully submitted.');
                emailForm.reset();
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error submitting your email.');
        });
    });

    // Function to validate email format
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }
});
