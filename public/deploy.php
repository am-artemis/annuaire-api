<?php

date_default_timezone_set('Europe/Paris');

class Deploy {

    /**
     * A callback function to call after the deploy has finished.
     * 
     * @var callback
     */
    public $post_deploy;

    /**
     * The name of the file that will be used for logging deployments. Set to 
     * FALSE to disable logging.
     * 
     * @var string
     */
    private $_log = 'deploy.log';

    /**
     * The timestamp format used for logging.
     * 
     * @link    http://www.php.net/manual/en/function.date.php
     * @var     string
     */
    private $_date_format = 'Y-m-d H:i:sP';

    /**
     * The name of the branch to pull from.
     * 
     * @var string
     */
    private $_branch = 'production';

    /**
     * The name of the remote to pull from.
     * 
     * @var string
     */
    private $_remote = 'origin';

    /**
     * The directory where your website and git repository are located, can be 
     * a relative or absolute path
     * 
     * @var string
     */
    private $_directory;

    /**
     * Sets up defaults.
     * 
     * @param  string  $directory  Directory where your website is located
     * @param  array   $data       Information about the deployment
     */
    public function __construct($directory, $options = array())
    {
        // Determine the directory path
        $this->_directory = realpath($directory).DIRECTORY_SEPARATOR;

        $available_options = array('log', 'date_format', 'branch', 'remote');

        foreach ($options as $option => $value)
        {
            if (in_array($option, $available_options))
            {
                $this->{'_'.$option} = $value;
            }
        }

        $this->log('Attempting deployment...');
    }

    /**
     * Writes a message to the log file.
     * 
     * @param  string  $message  The message to write
     * @param  string  $type     The type of log message (e.g. INFO, DEBUG, ERROR, etc.)
     */
    public function log($message, $type = 'INFO')
    {
        if ($this->_log)
        {
            // Set the name of the log file
            $filename = $this->_log;

            if ( ! file_exists($filename))
            {
                // Create the log file
                file_put_contents($filename, '');

                // Allow anyone to write to log files
                chmod($filename, 0666);
            }

            // Write the message into the log file
            // Format: time --- type: message
           
	    file_put_contents($filename, date($this->_date_format).' --- '.$type.': '.$message.PHP_EOL, FILE_APPEND);
        }
    }

    /**
     * Executes the necessary commands to deploy the website.
     */
    public function execute()
    {
        try
        {
            // Make sure we're in the right directory
            unset($output);
	    exec('cd '.$this->_directory, $output);
            $this->log('Changing working directory... '.implode(' ', $output));

            // Discard any changes to tracked files since our last deploy
	    unset($output);
            exec('git reset --hard HEAD', $output);
            $this->log('Reseting repository... '.implode(' ', $output));

            // Update the local repository
            unset($output);
	    exec('git pull '.$this->_remote.' '.$this->_branch, $output);
            $this->log('Pulling in changes... '.implode(' ', $output));

            // Secure the .git directory
	    unset($output);
            exec('chmod -R og-rx .git', $output);
            $this->log('Securing .git directory... '.implode(' ', $output));

            if (is_callable($this->post_deploy))
            {
                call_user_func($this->post_deploy, $this->_data);
            }

            $this->log('Deployment successful.');
        }
        catch (Exception $e)
        {
            $this->log($e, 'ERROR');
        }
    }

}


$deploy = new Deploy('/usr/share/nginx/html');

$deploy->post_deploy = function() use ($deploy) {

    // Composer install
    unset($output);
    exec('composer install -d ../ 2>&1', $output);
    $deploy->log("Composer install:\n" . implode("\n", $output));

    // Message slack
    unset($output);
    exec('curl -X POST --data-urlencode \'payload={"channel": "#artemisv2", "username": "DeployBot", "text": "New deployment on the API server !", "icon_emoji": ":ghost:"}\' https://hooks.slack.com/services/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 2>&1', $output);
    $deploy->log('Un ptit message slack.. '.implode(' / ', $output));

};

$deploy->execute();
