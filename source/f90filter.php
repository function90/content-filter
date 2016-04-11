<?php
/**
 * @package 	Plugin Content Filter for Joomla! 3.X
 * @version 	0.0.1
 * @author 		Function90.com
 * @copyright 	C) 2013- Function90.com
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
**/
defined( '_JEXEC' ) or die( 'Restricted access' );

class plgContentF90filter extends JPlugin
{
        public function onContentPrepare($context, &$row, &$params, $page = 0)
        {
			if(JFactory::getApplication()->isAdmin()){
				return true;
			}

       		if ( JString::strpos( $row->text, 'f90filter' ) === false ){
            	return true;
			}
                        
			// Search for this tag in the content
			$regex = "#{f90filter(.*?)}(.*?){/f90filter}#s";
            $row->text = preg_replace_callback( $regex, array($this, 'process'), $row->text );
            return true;
        }
        
		// for flexi content component
 		public function onContentBeforeDisplay($context, &$row, &$params, $page = 0)
        {
			if(JFactory::getApplication()->isAdmin()){
				return true;
			}

        	$this->onContentPrepare($context, $row, $params, $page);
        }

	/**
     * preg_match callback to process each match
     */
    public function process($match)
    {
		$ret = '';
        $content_show = 'SHOW';
        $content_hide = 'HIDE';
                
        if(!isset($match[2])){
        	return '';
        }
                
        $user = JFactory::getUser();
        $user_groups = $user->getAuthorisedGroups();
            
        if(empty($match[1])){
            return $match[2];
        }
            
        $match[1] = str_replace("&nbsp;", " ", $match[1]);

        $match[1] = htmlentities($match[1], null, 'utf-8');
        $match[1] = str_replace("&nbsp;", " ", $match[1]);
        $match[1] = html_entity_decode($match[1]);

        $rules = trim($match[1]);
        $rules = explode(' ', $rules);
        
        $token  = trim(array_shift($rules));
        $action = 'SHOW'; 
        if(count($rules) > 0){
        	$action = trim(array_shift($rules));
        }     

        $valid_msg = $match[2];
        $invalid_msg = '';
        if($action == 'HIDE'){
        	$invalid_msg = $match[2];
        	$valid_msg = '';
        }
        
        $tokens = $this->getTokens();
            
        if(!isset($tokens[$token])){
            return $valid_msg;
        }

        if(count(array_intersect($user_groups, $tokens[$token])) > 0){
        	return $valid_msg;
        }
        
        return $invalid_msg;
    }
        
	public function getTokens()
    {
    	static $tokens = null;
    	
    	if($tokens !== null){
    		return $tokens;
    	}
    	
    	$token_mapping = $this->params->get('mapping', '');
        if(empty($token_mapping)){
        	$tokens = array();
        	return $tokens;
        }
            
        $tokens = array();
        foreach($token_mapping as $mapping){
            if(empty($mapping->token)){
            	continue;
            }
            
            $tokens[trim($mapping->token)] = $mapping->groups;
        }
        
        return $tokens;
	}
}
