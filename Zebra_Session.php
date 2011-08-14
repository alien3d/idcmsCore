<?php

/**
 *  A PHP class that acts as a wrapper for PHP's default session handling functions but instead of storing session data
 *  in flat files it stores them in a MySQL database, thus providing both better security and better performance.
 *
 *  The class also implements <i>session locking</i>. Session locking is a way to ensure that data is correctly handled
 *  in a scenario with multiple concurrent AJAX requests. Read more about it in this excellent article by <b>Andy Bakun</b>
 *  called {@link http://thwartedefforts.org/2006/11/11/race-conditions-with-ajax-and-php-sessions/ Race Conditions with Ajax and PHP Sessions}.
 *
 *  The Zebra_Session class is also a solution for applications that are scaled across multiple web servers (using a
 *  load balancer or a round-robin DNS) and where the user's session data needs to be available. Storing sessions in a
 *  database makes them available to all of the servers!
 *
 *  This class is was inspired by John Herren's code from the {@link http://devzone.zend.com/node/view/id/141 Trick out
 *  your session handler} article and Chris Shiflett's code from his book {@link http://phpsecurity.org/code/ch08-2
 *  Essential PHP Security} chapter 8, Shared Hosting, Pg. 78-80.
 *
 *  The code is heavily commented and generates no warnings/errors/notices when PHP's error reporting level is set to
 *  E_ALL.
 *
 *  Visit {@link http://stefangabos.ro/php-libraries/zebra-session/} for more information.
 *
 *  For more resources visit {@link http://stefangabos.ro/}
 *
 *  @author     Stefan Gabos <contact@stefangabos.ro>
 *  @version    2.0 (last revision: April 18, 2011)
 *  @copyright  (c) 2006 - 2011 Stefan Gabos
 *  @license    http://www.gnu.org/licenses/lgpl-3.0.txt GNU LESSER GENERAL PUBLIC LICENSE
 *  @package    Zebra_Session
 */

class Zebra_Session
{

    /**
     *  Constructor of class. Initializes the class and automatically calls
     *  {@link http://php.net/manual/en/function.session-start.php start_session()}.
     *
     *  <code>
     *  //  include the class
     *  require 'path/to/Zebra_Session.php';
     *
     *  //  start the session
     *  $session = new Zebra_Session();
     *  </code>
     *
     *  @param int     $session_lifetime   (Optional) The number of seconds after which a session will be considered
     *                                          as <i>expired</i>.
     *
     *                                          Expired sessions are cleaned up from the database whenever the <i>garbage
     *                                          collection routine</i> is run. The probability of the <i>garbage collection
     *                                          routine</i> to be executed is given by the values of <i>$gc_probability</i>
     *                                          and <i>$gc_divisor</i>. See below.
     *
     *                                          Default is the value of <i>session.gc_maxlifetime</i> as set in in php.ini.
     *                                          Read more at {@link http://www.php.net/manual/en/session.configuration.php}
     *
     *                                          To clear any confusions that may arise: in reality, <i>session.gc_maxlifetime</i>
     *                                          does not represent a session's lifetime but the number of seconds after
     *                                          which a session is seen as <i>garbage</i> and is deleted by the <i>garbage
     *                                          collection routine</i>. The PHP setting that sets a session's lifetime is
     *                                          <i>session.cookie_lifetime</i> and is usually set to "0" - indicating that
     *                                          a session is active until the browser/browser tab is closed. When this class
     *                                          is used, a session is active until the browser/browser tab is closed and/or
     *                                          a session has been inactive for more than the number of seconds specified
     *                                          by <i>session.gc_maxlifetime</i>.
     *
     *                                          To see the actual value of <i>session.gc_maxlifetime</i> for your
     *                                          environment, use the {@link get_settings()} method.
     *
     *  @param int     $gc_probability     (Optional) Used in conjunction with <i>$gc_divisor</i>. It defines the
     *                                          probability that the <i>garbage collection routine</i> is started.
     *
     *                                          The probability is expressed by the formula:
     *
     *                                          <code>
     *                                          $probability = $gc_probability / $gc_divisor;
     *                                          </code>
     *
     *                                          So, if <i>$gc_probability</i> is 1 and <i>$gc_divisor</i> is 100, it means
     *                                          that there is a 1% chance the the <i>garbage collection routine</i> will
     *                                          be called on each request.
     *
     *                                          Default is the value of <i>session.gc_probability</i> as set in php.ini.
     *                                          Read more at {@link http://www.php.net/manual/en/session.configuration.php}
     *
     *                                          To see the actual value of <i>session.gc_probability</i> for your
     *                                          environment, and the computed <i>probability</i>, use the
     *                                          {@link get_settings()} method.
     *
     *  @param int     $gc_divisor         (Optional) Used in conjunction with <i>$gc_probability</i>. It defines the
     *                                          probability that the <i>garbage collection routine</i> is started.
     *
     *                                          The probability is expressed by the formula:
     *
     *                                          <code>
     *                                          $probability = $gc_probability / $gc_divisor;
     *                                          </code>
     *
     *                                          So, if <i>$gc_probability</i> is 1 and <i>$gc_divisor</i> is 100, it means
     *                                          that there is a 1% chance the the <i>garbage collection routine</i> will
     *                                          be called on each request.
     *
     *                                          Default is the value of <i>session.gc_divisor</i> as set in php.ini.
     *                                          Read more at {@link http://www.php.net/manual/en/session.configuration.php}
     *
     *                                          To see the actual value of <i>session.gc_divisor</i> for your
     *                                          environment, and the computed <i>probability</i>, use the
     *                                          {@link get_settings()} method.
     *
     *  @param  string      $security_code      (Optional) The value of this argument is appended to the HTTP_USER_AGENT
     *                                          string before creating an MD5 hash out of it and storing it in the database.
     *                                          This way we'll try to prevent HTTP_USER_AGENT spoofing.
     *
     *                                          <i>Make sure you change this code to something else!</i>
     *
     *                                          Default is <i>sEcUr1tY_c0dE</i>
     *
     *  @param  string      $table_name         (Optional) Name of the MySQL table used by the class.
     *
     *                                          Default is <i>session_data</i>.
     *
     *  @param  string      $lock_timeout       (Optional) The maximum amount of time (in seconds) for which a lock on
     *                                          the session data can be kept.
     *
     *                                          <i>This must be lower than the maximum execution time of the script!</i>
     *
     *                                          Session locking is a way to ensure that data is correctly handled in a
     *                                          scenario with multiple concurrent AJAX requests.
     *
     *                                          Read more about it at
     *                                          {@link http://thwartedefforts.org/2006/11/11/race-conditions-with-ajax-and-php-sessions/}
     *
     *                                          Default is <i>60</i>
     *
     *  @return void
     */
    function Zebra_Session($session_lifetime = '', $gc_probability = '', $gc_divisor = '', $security_code = 'sEcUr1tY_c0dE', $table_name = 'session_data', $lock_timeout = 60)
    {

        // continue if there is an active MySQL connection
        if (@mysql_ping()) {

            // make sure session cookies never expire so that session lifetime
            // will depend only on the value of $session_lifetime
            ini_set('session.cookie_lifetime', 0);

            // if $session_lifetime is specified and is an integer number
            if ($session_lifetime != '' && is_integer($session_lifetime)) {

                // set the new value
                ini_set('session.gc_maxlifetime', $session_lifetime);

            }

            // if $gc_probability is specified and is an integer number
            if ($gc_probability != '' && is_integer($gc_probability)) {

                // set the new value
                ini_set('session.gc_probability', $gc_probability);

            }

            // if $gc_divisor is specified and is an integer number
            if ($gc_divisor != '' && is_integer($gc_divisor)) {

                // set the new value
                ini_set('session.gc_divisor', $gc_divisor);

            }

            // get session lifetime
            $this->session_lifetime = ini_get('session.gc_maxlifetime');

            // we'll use this later on in order to try to prevent HTTP_USER_AGENT spoofing
            $this->security_code = $security_code;

            // the table to be used by the class
            $this->table_name = $table_name;

            // the maximum amount of time (in seconds) for which a process can lock the session
            $this->lock_timeout = $lock_timeout;

            // register the new handler
            session_set_save_handler(
                array(&$this, 'open'),
                array(&$this, 'close'),
                array(&$this, 'read'),
                array(&$this, 'write'),
                array(&$this, 'destroy'),
                array(&$this, 'gc')
            );

            // start the session
            session_start();

        // if no MySQL connections could be found
        } else {

            // trigger a fatal error message and stop execution
            trigger_error('<br>No MySQL connection!<br>Error', E_USER_ERROR);

        }

    }

    /**
     *  Custom close() function
     *
     *  @access private
     */
    function close()
    {

        // release the lock associated with the current session
        mysql_query('SELECT RELEASE_LOCK("' . $this->session_lock . '")')

            // stop execution and print message on error
            or die(mysql_error());

        return true;

    }

    /**
     *  Custom destroy() function
     *
     *  @access private
     */
    function destroy($session_id)
    {

        // deletes the current session id from the database
        $result = mysql_query('

            DELETE FROM
                ' . $this->table_name . '
            WHERE
                session_id = "' . mysql_real_escape_string($session_id) . '"

        ') or die(mysql_error());

        // if anything happened
        if (mysql_affected_rows() !== -1) {

            // return true
            return true;

        }

        // if something went wrong, return false
        return false;

    }

    /**
     *  Custom gc() function (garbage collector)
     *
     *  @access private
     */
    function gc($maxlifetime)
    {

        // it deletes expired sessions from database
        $result = mysql_query('

            DELETE FROM
                ' . $this->table_name . '
            WHERE
                session_expire < "' . mysql_real_escape_string(time() - $maxlifetime) . '"

        ') or die(mysql_error());

    }
	
    /**
     *  Get the number of active sessions - sessions that have not expired.
     *
     *  <i>The returned value does not represent the exact number of active users as some sessions may be unused
     *  although they haven't expired.</i>
     *
     *  <code>
     *  //  include the class
     *  require 'path/to/Zebra_Session.php';
     *
     *  //  start the session
     *  $session = new Zebra_Session();
     *
     *  //  get the (approximate) number of active sessions
     *  $active_sessions = $session->get_active_sessions();
     *  </code>
     *
     *  @return integer     Returns the number of active (not expired) sessions.
     */
    function get_active_sessions()
    {

        // call the garbage collector
        $this->gc($this->session_lifetime);

        // counts the rows from the database
        $result = @mysql_fetch_assoc(mysql_query('

            SELECT
                COUNT(session_id) as count
            FROM ' . $this->table_name . '

        ') or die(mysql_error()));

        // return the number of found rows
        return $result['count'];

    }

    /**
     *  Queries the system for the values of <i>session.gc_maxlifetime</i>, <i>session.gc_probability</i> and <i>session.gc_divisor</i>
     *  and returns them as an associative array.
     *
     *  To view the result in a human-readable format use:
     *  <code>
     *  //  include the class
     *  require 'path/to/Zebra_Session.php';
     *
     *  //  instantiate the class
     *  $session = new Zebra_Session();
     *
     *  //  get default settings
     *  print_r('<pre>');
     *  print_r($session->get_settings());
     *
     *  //  would output something similar to (depending on your actual settings)
     *  //  Array
     *  //  (
     *  //      [session.gc_maxlifetime] => 1440 seconds (24 minutes)
     *  //      [session.gc_probability] => 1
     *  //      [session.gc_divisor] => 1000
     *  //      [probability] => 0.1%
     *  //  )
     *  </code>
     *
     *  @since 1.0.8
     *
     *  @return array   Returns the values of <i>session.gc_maxlifetime</i>, <i>session.gc_probability</i> and <i>session.gc_divisor</i>
     *                  as an associative array.
     *
     */
    function get_settings()
    {

        // get the settings
        $gc_maxlifetime = ini_get('session.gc_maxlifetime');
        $gc_probability = ini_get('session.gc_probability');
        $gc_divisor     = ini_get('session.gc_divisor');

        // return them as an array
        return array(
            'session.gc_maxlifetime'    =>  $gc_maxlifetime . ' seconds (' . round($gc_maxlifetime / 60) . ' minutes)',
            'session.gc_probability'    =>  $gc_probability,
            'session.gc_divisor'        =>  $gc_divisor,
            'probability'               =>  $gc_probability / $gc_divisor * 100 . '%',
        );

    }

    /**
     *  Custom open() function
     *
     *  @access private
     */
    function open($save_path, $session_name)
    {

        return true;

    }

    /**
     *  Custom read() function
     *
     *  @access private
     */
    function read($session_id)
    {

        // get the lock name, associated with the current session
        $this->session_lock = mysql_real_escape_string('session_' . $session_id);

        // try to obtain a lock with the given name and timeout
        $result = mysql_query('SELECT GET_LOCK("' . $this->session_lock . '", ' . mysql_real_escape_string($this->lock_timeout) . ')');

        // if there was an error
        if (!is_resource($result) || @mysql_num_rows($result) != 1) {

            // stop execution
            die('Could not obtain session lock!');

        }

        //  reads session data associated with a session id, but only if
        //  -   the session ID exists;
        //  -   the session has not expired;
        //  -   the HTTP_USER_AGENT is the same as the one who had previously been associated with this particular session;
        $result = mysql_query('

            SELECT
                session_data
            FROM
                ' . $this->table_name . '
            WHERE
                session_id = "' . mysql_real_escape_string($session_id) . '" AND
                session_expire > "' . time() . '" AND
                http_user_agent = "' . mysql_real_escape_string(md5((isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '') . $this->security_code)) . '"
            LIMIT 1

        ') or die(mysql_error());

        // if anything was found
        if (is_resource($result) && @mysql_num_rows($result) > 0) {

            // return found data
            $fields = @mysql_fetch_assoc($result);

            // don't bother with the unserialization - PHP handles this automatically
            return $fields['session_data'];

        }

        // on error return an empty string - this HAS to be an empty string
        return '';

    }

    /**
     *  Regenerates the session id.
     *
     *  <b>Call this method whenever you do a privilege change in order to prevent session hijacking!</b>
     *
     *  <code>
     *  //  include the class
     *  require 'path/to/Zebra_Session.php';
     *
     *  //  start the session
     *  $session = new Zebra_Session();
     *
     *  //  regenerate the session's ID
     *  $session->regenerate_id();
     *  </code>
     *
     *  @return void
     */
    function regenerate_id()
    {

        // saves the old session's id
        $old_session_id = session_id();

        // regenerates the id
        // this function will create a new session, with a new id and containing the data from the old session
        // but will not delete the old session
        session_regenerate_id();

        // because the session_regenerate_id() function does not delete the old session,
        // we have to delete it manually
        $this->destroy($old_session_id);

    }

    /**
     *  Deletes all data related to the session
     *
     *  <code>
     *  //  include the class
     *  require 'path/to/Zebra_Session.php';
     *
     *  //  start the session
     *  $session = new Zebra_Session();
     *
     *  //  end current session
     *  $session->stop();
     *  </code>
     *
     *  @since 1.0.1
     *
     *  @return void
     */
    function stop()
    {

        $this->regenerate_id();

        session_unset();

        session_destroy();

    }

    /**
     *  Custom write() function
     *
     *  @access private
     */
    function write($session_id, $session_data)
    {

        // insert OR update session's data - this is how it works:
        // first it tries to insert a new row in the database BUT if session_id is already in the database then just
        // update session_data and session_expire for that specific session_id
        // read more here http://dev.mysql.com/doc/refman/4.1/en/insert-on-duplicate.html
        $result = mysql_query('

            INSERT INTO
                ' . $this->table_name . ' (
                    session_id,
                    http_user_agent,
                    session_data,
                    session_expire
                )
            VALUES (
                "' . mysql_real_escape_string($session_id) . '",
                "' . mysql_real_escape_string(md5((isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '') . $this->security_code)) . '",
                "' . mysql_real_escape_string($session_data) . '",
                "' . mysql_real_escape_string(time() + $this->session_lifetime) . '"
            )
            ON DUPLICATE KEY UPDATE
                session_data = "' . mysql_real_escape_string($session_data) . '",
                session_expire = "' . mysql_real_escape_string(time() + $this->session_lifetime) . '"

        ') or die(mysql_error());

        // if anything happened
        if ($result) {

            // note that after this type of queries, mysql_affected_rows() returns
            // - 1 if the row was inserted
            // - 2 if the row was updated

            // if the row was updated
            if (@mysql_affected_rows() > 1) {

                // return TRUE
                return true;

            // if the row was inserted
            } else {

                // return an empty string
                return '';

            }

        }

        // if something went wrong, return false
        return false;

    }

}
?>
