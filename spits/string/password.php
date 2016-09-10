<?php
// Get the string utility class
require_once 'utils/String.php';

// Page title
$pagetitle = 'Random password generator';

// Default password string
$password = '';

// Get the dropdown for lengths
$lengths = range(8,24);

// Get the user requested length if there is one, otherwise default to 12
$length = Request::post('length', 12);

// Get the user requested types if there are any
$types = Request::post('types', []);

// Add shuffle?
$shuffle = Request::post('shuffle') === 'on';

// If the form was posted, handle it
if (Request::is('post')) {
    $password = String::getRandom($length, !empty($types['int']), true, !empty($types['upper']), !empty($types['special']));

    if ($shuffle) {
        $password = str_shuffle($password);
    }
}
?>
    <h1 id="page-title"><?php echo $pagetitle ?></h1>
    <p>
        This little script creates a random password string. For a list of random strings, check out <a href="random.php">the random string maker</a>.<br /><br />
        <small></small>
    </p>

    <fieldset>
        <legend><?php echo $pagetitle ?></legend>
        <form id="password-maker" method="post" action="">
            <p>Password Length:
            <select name="length" id="length">
                <?php foreach ($lengths as $l): ?>
                <option value="<?php echo $l ?>"<?php if ($l == $length): ?> selected="selected"<?php endif; ?>><?php echo $l ?></option>
                <?php endforeach; ?>
            </select>
            </p>
            <p>
                <input type="checkbox" name="types[alpha]" checked="checked" disabled="disabled" />
                Add lowercase alpha characters (default and required)
            </p>
            <p>
                <input type="checkbox" name="types[upper]"<?php if (!empty($types['upper'])): ?> checked="checked"<?php endif; ?> />
                Add UPPERCASE alpha characters
            </p>
            <p>
                <input type="checkbox" name="types[int]"<?php if (!empty($types['int'])): ?> checked="checked"<?php endif; ?> />
                Add numbers
            </p>
            <p>
                <input type="checkbox" name="types[special]"<?php if (!empty($types['special'])): ?> checked="checked"<?php endif; ?> />
                Add special characters
            </p>
                <input type="checkbox" name="shuffle"<?php if ($shuffle): ?> checked="checked"<?php endif; ?> />
                Shuffle initial generated password chars
            </p>
            <p><input type="submit" name="submit" value="Generate password" /></p>
        </form>
    </fieldset>

    <?php if ($password): ?>
    <hr />
    <h2 id="password">Generated Password</h2>
    <pre><?php echo $password ?></pre>
    <?php endif; ?>