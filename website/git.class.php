<?php
/**
 * GitLib-Hook API
 * Created by Rchockxm
 * Developer: Rchockxm (rchockxm.silver@gmail.com)
 * Filename: git.class.php
 */
namespace Gitlab\Git\Hook;

 /**
 * Git Hook BaseWebsite
 */
class BaseWebsite {
    
    private $__deploy = null;
    
    /**
     * __construct
     *
     * @type public
     * @params void
     * @return void
     *         void
     */
    public function __construct() {
        $this->__deploy = new \stdClass();
        $this->__deploy->path = "";
        $this->__deploy->bash = "";
        $this->__deploy->branch = "";
    }
    
    /**
     * __destruct
     *
     * @type public
     * @params void
     * @return void
     *         void
     */
    public function __destruct() {
        $this->__deploy = null;
    }
    
    /**
     * setEnvironment
     *
     * @type public
     * @params [optional $isDeveloperEnv]
     * @return void
     *         void
     */
    public function setEnvironment($isDeveloperEnv = true) {
        if ((boolean)$isDeveloperEnv == false) {
            $this->__deploy->git = GIT_URL;
            $this->__deploy->gitTest = GIT_TEST_URL;
            $this->__deploy->path = DIR_PRODUCTION_DEPLOY;
            $this->__deploy->bash = PRODUCTION_SH_DEPLOY;
            $this->__deploy->branch = PRODUCTION_BRANCH;
            $this->__deploy->branchRefs = PRODUCTION_BRANCH_REFS;
        }
        else {
            $this->__deploy->git = GIT_URL;
            $this->__deploy->gitTest = GIT_TEST_URL;
            $this->__deploy->path = DIR_DEVELOPER_DEPLOY;
            $this->__deploy->bash = DEVELOPER_SH_DEPLOY;
            $this->__deploy->branch = DEVELOPER_BRANCH;
            $this->__deploy->branchRefs = DEVELOPER_BRANCH_REFS;
        }
    }
    
    /**
     * setRealGitUrl
     *
     * @type public
     * @params $url, $oldDomain, $newDomain
     * @return void
     *         void
     */
    public function setRealGitUrl($url, $oldDomain, $newDomain) {
        return str_replace($oldDomain, $newDomain, $url);
    }
    
    /**
     * generateBash
     *
     * @type public
     * @params $repository, [optional $branch, $path]
     * @return string
     *         empty string
     */
    public function generateBash($repository, $branch = "", $path = "") {
        $ret = "";
        
        $branch = (!empty($branch)) ? $branch : $this->__deploy->branch;
        $path = (!empty($path)) ? $path : $this->__deploy->path;
        
        $repo = new \stdClass();
        $repo->name = "";
        $repo->url = "";
        
        if (is_array($repository)) {
            $repo->name = (array_key_exists("name", $repository)) ? (string)$repository["name"] : $repo->name;
            $repo->url = (array_key_exists("git_http_url", $repository)) ? (string)$repository["git_http_url"] : $repo->url;
        }
        
        $repositoryPath = (string)$path . (string)$repo->name;
        $repositoryGitPath = (string)$path . (string)$repo->name . "/.git";
        
        if (file_exists($repositoryPath) && file_exists($repositoryGitPath)) {
            $ret = "cd " . (string)$repositoryPath . " \r\n";
            $ret .= "git checkout " . (string)$branch . " \r\n";
            $ret .= "git pull origin " . (string)$branch . " \r\n";
        }
        else {
            $repo->url = $this->setRealGitUrl($repo->url, $this->__deploy->gitTest, $this->__deploy->git);
            
            if (!empty($repo->url)) {
                $ret = "cd " . (string)$path . " \r\n";
                $ret .= "git clone " . (string)$repo->url . " \r\n";
            }
        }
        
        $repositoryGitPath = null;
        $repositoryPath = null;
        
        $repo = null;
        
        return $ret;
    }
    
    /**
     * runRepository
     *
     * @type public
     * @params [optional $branchRefs]
     * @return boolean(true)
     *         boolean(false)
     */
    public function runRepository($branchRefs = "") {
        $ret = false;
        $strJSON = file_get_contents('php://input');
        $varData = null;
        
        if (empty($branchRefs)) {
            $branchRefs = $this->__deploy->branchRefs;
        }
        
        if (!empty($strJSON)) {
            $varData = json_decode($strJSON, true);
        }
        
        if (is_array($varData)) {
            $varRepository = (array_key_exists("repository", $varData)) ? $varData["repository"] : "";
            $strBranch = (array_key_exists("ref", $varData)) ? (string)$varData["ref"] : "";
            $strGashCommand = "";
            
            if (is_array($varRepository) 
                && (strtolower($strBranch) == strtolower($branchRefs))) {
                    
                $strGashCommand = $this->generateBash($varRepository);
                //$strGashCommand = DIR_APPLICATION_WEBSITE_BASH . (string)$this->__deploy->bash;
            }
            
            if (!empty($strGashCommand)) {
                $ret = shell_exec($strGashCommand);
            }
            
            $strGashCommand = null;
            $strBranch = null;
            $varRepository = null;
        }
        
        if (file_exists(DIR_APPLICATION_LOGS)) {
            file_put_contents(DIR_APPLICATION_LOGS . date("Y-m-d") . ".log", $strJSON);
        }
        
        $varData = null;
        $strJSON = null;
        
        return $ret;
    }
}
?>
