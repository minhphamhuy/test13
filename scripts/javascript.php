<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // process admin update account details form
        $('#admin-signup').submit(function(event) {
           
            // get the form data
            var formData = {
                'first_name'        : $('input[name=first_name]').val(),
                'last_name'         : $('input[name=last_name]').val(),
                'email'             : $('input[name=email]').val(),
                'phone'             : $('input[name=phone]').val(),
                'oldpassword'       : $('input[name=oldpassword]').val(),
                'newpassword'       : $('input[name=newpassword]').val(),
                'renewpassword'     : $('input[name=renewpassword]').val(),
                'update-admin'      : $('input[name=update-admin]').val()
            };

            // process the form
            $.ajax({
                type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url         : './scripts/test.php', // the url where we want to POST
                data        : formData, // our data object
                dataType    : 'json', // what type of data do we expect back from the server
                encode      : true,
                error: function(jqXHR, textStatus, errorThrown)
                {
                    // Handle errors here
                    console.log('ERRORS: ' + textStatus, errorThrown);
                }
            })

            // using the done promise callback
            .done(function(data) {

                // log data to the console so we can see
                console.log(data);

                // here we will handle errors and validation messages
                if (!data.success) {
                    if (data.errors.name) {
                        $('#error-group').append('<div>' + data.errors.name + '</div>');
                    }
                    if (data.errors.email) {
                        $('#error-group').append('<div>' + data.errors.email + '</div>');
                    }
                    if (data.errors.phone) {
                        $('#error-group').append('<div>' + data.errors.phone + '</div>'); 
                    }
                    if (data.errors.password) {
                        $('#error-group').append('<div>' + data.errors.password + '</div>'); 
                    }
                } else {
                    // ALL GOOD! just show the success message!
                    $('#success-group').append('<div>' + data.sucessMsg.first_name + '</div>');
                    $('#success-group').append('<div>' + data.sucessMsg.last_name + '</div>');
                    $('#success-group').append('<div>' + data.sucessMsg.email + '</div>');
                    $('#success-group').append('<div>' + data.sucessMsg.phone + '</div>');
                    $('#success-group').append('<div>' + data.sucessMsg.password + '</div>');
                }
            })
            
            // using the fail promise callback
            .fail(function(data) {
                //Server failed to respond - Show an error message
                $('#admin-signup').html('<div class="alert alert-danger">Could not reach server, please try again later.</div>');
            });
             // stop the form from submitting the normal way and refreshing the page
             event.preventDefault();

        });
    });

    ///////////////////////////////////////////
    function goBack() {
        window.history.back();
    }

    function checkLogin(e) {
        var username = password = "";
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        //validate username
        if (username == "") {
            alert("Please fill in your username");
            e.preventDefault();
            return false;
        } else {
            return true;
        }

        //validate password
        if (password == "") {
            alert("Please fill in your password");
            e.preventDefault();
            return false;
        } else {
            return true;
        }
    }

    function checkSignup(e) {
        var last_name = first_name = email = phone = username = password = "";
        var last_name = document.getElementById('last_name').value;
        var first_name = document.getElementById('first_name').value;
        var email = document.getElementById('email').value;
        var phone = document.getElementById('phone').value;
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var name_regex = /^[A-Za-z]+$/;
        var email_regex = /^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/;
        var phone_regex = /^\+?\d{0,13}/s;
        var password_regex = /^(?=.{4,20}$)(?:[a-zA-Z\d]+(?:(?:\.|-|_)[a-zA-Z\d])*)+$/;
        //validate name
        if (first_name == "" || last_name == "") {
            alert("Please fill in your name");
            e.preventDefault();
            return false;
        } else if (name_regex.test(first_name) == false || name_regex.test(last_name) == false) {
            alert("Invalid name!");
            e.preventDefault();
            return false;
        } else {
            return true;
        }

        //validate email
        if (email == "") {
            alert("Please fill in your email");
            e.preventDefault();
            return false;
        } else if (email_regex.test(email) == false) {
            alert("Invalid email format!");
            e.preventDefault();
            return false;
        } else {
            return true;
        }

        //validate phone
        if (phone == "") {
            alert("Please fill in your phone number");
            e.preventDefault();
            return false;
        } else if (phone_regex.test(phone) == false) {
            alert("Invalid phone number!");
            e.preventDefault();
            return false;
        } else {
            return true;
        }

        //validate username
        if (username == "") {
            alert("Please fill in your username");
            e.preventDefault();
            return false;
        } else {
            return true;
        }

        //validate password
        if (password == "") {
            alert("Please fill in your password");
            e.preventDefault();
            return false;
            // } else if (password_regex.test(password) == false ) {
            //     alert("Password should be atleast 4 characters and have atleast one capital letter");
            //     e.preventDefault();
            //     return false;
        } else {
            return true;
        }
    }

    function UpdateCheckBox(tgl, start, stop) {
        for (var i = start; i <= stop; i++) {
            if (document.getElementById('p' + i)) {
                if (document.getElementById('p' + tgl).checked == true) {
                    document.getElementById('p' + i).checked = true;
                } else {
                    document.getElementById('p' + i).checked = false;
                }
            }
        }

        // Other Arguments is individual items not available in the range
        if (arguments.length > 3) {
            for (var lp = 4; lp <= arguments.length; lp++) {
                if ($('p' + arguments[lp - 1])) {
                    $('p' + arguments[lp - 1]).checked = $('p' + tgl).checked;
                }
            }
        }
    }

    function confirmDeleteUser(e) {
        if (confirm("Do you want to remove user?") == false) {
            e.preventDefault();
        } else {
            e.target.type = "submit";
            e.target.submit();
        }
    }

    // When admin clicks on 'Danger zone' bar,toggle between 
    // hiding and showing the delete button
    function showButton() {
        var delButtons = document.getElementsByClassName("delete-button");
        for (i = 0; i < delButtons.length; i++) {
            var delButtonOpen = delButtons[i];
            delButtonOpen.classList.toggle("show");
        }
    }

    // toggle search form in admin's admin and customer listing page
    function toggleSearchSection() {
        var formElms = document.getElementsByClassName("search-form");
        for (i = 0; i < formElms.length; i++) {
            var form = formElms[i];
            if (form.classList.contains("showform")) {
                form.classList.remove("showform");
                form.classList.add("hideform");
            } else {
                form.classList.remove("hideform");
                form.classList.add("showform");
            }
        }
    }
</script>