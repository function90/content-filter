<?php
/**
 * @package 	Plugin Content Filter for Joomla! 3.X
 * @version 	0.0.1
 * @author 		Function90.com
 * @copyright 	C) 2013- Function90.com
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
**/
defined('_JEXEC') or die;

class F90FilterFormFieldGroups extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'Groups';

	/**
	 * Method to get the user group field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getInput()
	{
		$groups = $this->getJoomlaUserGroups();
		
		$html = '';
		ob_start();

		$version = new JVersion();
		$major  = str_replace('.', '', $version->RELEASE);
		if($major == '25'){
			include dirname(__FILE__).'/tmpl/groups25.php';
		}
		else{					
			include dirname(__FILE__).'/tmpl/groups.php';
		}	
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	public function getJoomlaUserGroups()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('a.*, COUNT(DISTINCT b.id) AS level')
			->from($db->quoteName('#__usergroups') . ' AS a')
			->join('LEFT', $db->quoteName('#__usergroups') . ' AS b ON a.lft > b.lft AND a.rgt < b.rgt')
			->group('a.id, a.title, a.lft, a.rgt, a.parent_id')
			->order('a.lft ASC');
		$db->setQuery($query);
		return $db->loadObjectList();
	}	
}
