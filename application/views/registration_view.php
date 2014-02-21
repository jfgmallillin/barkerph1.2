<div id="content">
    <div class="signup_wrap">
        <div class="signin_form">
            <?php echo form_open("user/login"); ?>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="" />
            <label for="pass">Password:</label>
            <input type="password" id="pass" name="pass" value="" />
            <input type="submit" class="" value="Sign in" />
            <?php echo form_close(); ?>
        </div><!--<div class="signin_form">-->
    </div><!--<div class="signup_wrap">-->
    <div class="reg_form">
        <div class="form_title">Sign Up</div>
        <div class="form_sub_title">It's free and anyone can join</div>
        <?php echo validation_errors('<p class="error">'); ?>
        <?php echo form_open("user/registration"); ?>
        <p>
            <label for="user_name">User Name:</label>
            <input type="text" id="user_name" name="user_name" value="<?php echo set_value('user_name'); ?>" /><span id="usr_verify" class="verify"></span>
        </p>        
        <p>
            <label for="email_address">Your Email:</label>
            <input type="text" id="email_address" name="email_address" value="<?php echo set_value('email_address'); ?>" /><span id="email_verify" class="verify"></span>
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" /><span id="password_verify" class="verify"></span>
        </p>
        <p>
            <label for="con_password">Confirm Password:</label>
            <input type="password" id="con_password" name="con_password" value="<?php echo set_value('con_password'); ?>" /><span id="confrimpwd_verify" class="verify"></span>
        </p>        
        <p>
            <input type="submit" class="greenButton" value="Submit" />
        </p>
        <?php echo form_close(); ?>
    </div><!--<div class="reg_form">-->    
</div><!--<div id="content">-->
<script type="text/javascript">
    $(document).ready(function() {
        $("#user_name").keyup(function() {
            if ($("#user_name").val().length >= 4)
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/user/check_user",
                    data: "name=" + $("#user_name").val(),
                    success: function(msg) {
                        if (msg == true)
                        {
                            $("#usr_verify").css({"background-image": "url('<?php echo base_url(); ?>images/yes.png')"});
                        }
                        else
                        {
                            $("#usr_verify").css({"background-image": "url('<?php echo base_url(); ?>images/no.png')"});
                        }
                    }
                });

            }
            else
            {
                $("#usr_verify").css({"background-image": "none"});
            }
        });

        $("#email_address").keyup(function() {
            var email = $("#email_address").val();

            if (email != 0)
            {

                if (isValidEmailAddress(email))
                {
                    $("#email_verify").css({"background-image": "url('<?php echo base_url(); ?>images/yes.png')"});
                    email_con = true;
                    register_show();
                } else {

                    $("#email_verify").css({"background-image": "url('<?php echo base_url(); ?>images/no.png')"});
                }

            }
            else {
                $("#email_verify").css({"background-image": "none"});
            }

        });

        $("#password").keyup(function() {

            if ($("#con_password").val().length >= 4)
            {
                if ($("#con_password").val() != $("#password").val())
                {
                    $("#confrimpwd_verify").css({"background-image": "url('<?php echo base_url(); ?>images/no.png')"});
                    $("#password_verify").css({"background-image": "url('<?php echo base_url(); ?>images/no.png')"});
                    pwd = false;
                    register_show();
                }
                else {
                    $("#confrimpwd_verify").css({"background-image": "url('<?php echo base_url(); ?>images/yes.png')"});
                    $("#password_verify").css({"background-image": "url('<?php echo base_url(); ?>images/yes.png')"});
                }
            }
        });

        $("#con_password").keyup(function() {

            if ($("#password").val().length >= 4)
            {
                if ($("#con_password").val() != $("#password").val())
                {
                    $("#confrimpwd_verify").css({"background-image": "url('<?php echo base_url(); ?>images/no.png')"});
                    $("#password_verify").css({"background-image": "url('<?php echo base_url(); ?>images/no.png')"});
                    pwd = false;
                    register_show();
                }
                else {
                    $("#confrimpwd_verify").css({"background-image": "url('<?php echo base_url(); ?>images/yes.png')"});
                    $("#password_verify").css({"background-image": "url('<?php echo base_url(); ?>images/yes.png')"});

                }
            }
        });
    });
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }
</script>
