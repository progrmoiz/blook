<?php
include_once '../../lib/bootstrap.php';
header('Content-Type: text/html; charset=UTF-8');

$location = isset($_SESSION['location']) ? $_SESSION['location'] : null;

include_once ACC . 'register.php';

$IsLoginOrRegisterPage = true;

include_once INC . 'head.php';

function akevr($key, $array) {
  return $array && array_key_exists($key, $array) ? $array[$key] : '';
}
?>
<div class="flex flex-1">
  <div class="relative w-2/3 bg-indigo-lightest"  style="background: url(<?= ROOT ?>/images/arif-riyanto-1208107-unsplash.jpg) top; background-size: cover;">
  <div class="absolute pin-b pin-r mb-2 mr-2">
  <a style="background-color:black;color:white;text-decoration:none;padding:4px 6px;font-family:-apple-system, BlinkMacSystemFont, &quot;San Francisco&quot;, &quot;Helvetica Neue&quot;, Helvetica, Ubuntu, Roboto, Noto, &quot;Segoe UI&quot;, Arial, sans-serif;font-size:12px;font-weight:bold;line-height:1.2;display:inline-block;border-radius:3px" href="https://unsplash.com/@arifriyanto?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from Arif Riyanto"><span style="display:inline-block;padding:2px 3px"><svg xmlns="http://www.w3.org/2000/svg" style="height:12px;width:auto;position:relative;vertical-align:middle;top:-1px;fill:white" viewBox="0 0 32 32"><title>unsplash-logo</title><path d="M20.8 18.1c0 2.7-2.2 4.8-4.8 4.8s-4.8-2.1-4.8-4.8c0-2.7 2.2-4.8 4.8-4.8 2.7.1 4.8 2.2 4.8 4.8zm11.2-7.4v14.9c0 2.3-1.9 4.3-4.3 4.3h-23.4c-2.4 0-4.3-1.9-4.3-4.3v-15c0-2.3 1.9-4.3 4.3-4.3h3.7l.8-2.3c.4-1.1 1.7-2 2.9-2h8.6c1.2 0 2.5.9 2.9 2l.8 2.4h3.7c2.4 0 4.3 1.9 4.3 4.3zm-8.6 7.5c0-4.1-3.3-7.5-7.5-7.5-4.1 0-7.5 3.4-7.5 7.5s3.3 7.5 7.5 7.5c4.2-.1 7.5-3.4 7.5-7.5z"></path></svg></span><span style="display:inline-block;padding:2px 3px">Arif Riyanto</span></a>
  </div>
  </div>
  <div class="w-1/3 p-3">
  <form class="px-8 pt-6 pb-8 mb-4" method="POST">
    <h1 class="text-grey-darker mb-5 pb-2 font-semibold">Sign Up</h1>
    <div class="mb-4">
      <label class="block text-grey-darker text-sm font-bold mb-2" for="full_name">
        Full Name
      </label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline mb-3" value="<?php echo $full_name; ?>" id="full_name" name="full_name" type="text" placeholder="Full Name">
      <p class="text-red text-xs italic"><?= akevr('full_name', $form->errors()) ?></p>
    </div>
    <div class="mb-4">
      <label class="block text-grey-darker text-sm font-bold mb-2" for="uname">
        Username
      </label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline mb-3" value="<?php echo $username; ?>" id="uname" name="uname" type="text" placeholder="Username">
      <p class="text-red text-xs italic"><?= akevr('uname', $form->errors()) ?></p>
    </div>
    <div class="mb-4">
      <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
        Email
      </label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline mb-3" value="<?php echo $email; ?>" id="email" name="email" type="email" placeholder="Email address">
      <p class="text-red text-xs italic"><?= akevr('email', $form->errors()) ?></p>
    </div>
    <div class="mb-4">
      <label class="block text-grey-darker text-sm font-bold mb-2" for="passwd">
        Password
      </label>
      <input class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline" id="passwd" name="passwd" type="password" placeholder="**********">
      <p class="text-red text-xs italic"><?= akevr('passwd', $form->errors()) ?></p>
    </div>
    <div class="mb-4">
      <label class="block text-grey-darker text-sm font-bold mb-2" for="passwd_conf">
        Confirm Password
      </label>
      <input class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline" id="passwd_conf" name="passwd_conf" type="password" placeholder="**********">
      <p class="text-red text-xs italic"><?= akevr('passwd_conf', $form->errors()) ?></p>
    </div>
    <div class="mb-2 flex flex-col">
      <div class="flex">
      <input id="agree" name="agree" type="checkbox">
      <label class="block text-grey-darker text-sm font-bold ml-3 mb-2" for="agree">
        I agree to the <a class="text-grey-darkest hover:text-black no-underline hover:underline" href="#">term of services</a>
      </label>
      </div>
      <p class="text-red text-xs italic"><?= akevr('agree', $form->errors()) ?></p>
    </div>
    <div class="flex items-center mb-4">
      <input class="bg-indigo hover:bg-indigo-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="signup" value="Sign Up">
    </div>
    <div class="text-xs text-grey-dark">
      Already have an account?
      <a class="no-underline hover:underline font-semibold inline-block text-indigo hover:text-indigo-darker" href="<?= ROOT ?>/login">
        Login here
      </a>
      </div>
  </form>
  </div>
</div>
<?php
  include_once INC . 'footer.php';