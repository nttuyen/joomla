<?php
jimport('joomla.application.component.model');
class weddingModelSurvey extends JModel 
{
	var $_data = null;
	var $_pagination = null;
	var $_total = null;
	
	function getSurveys($user_id)
	{
		if( empty( $this->_data ) )
		{
			$limit = 20;
			$limitstart = JRequest::getInt('limitstart');
			$query = $this->_buildQuery($user_id);
            $this->_data = $this->_getList($query, $limitstart, $limit); 
		}
		return $this->_data;
	}
	
	function getTotal($user_id)
	{
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'general.php');
		return generalHelpers::getTotal('#__wedding_surveys', 'id', 'user_id='.$user_id);
	}
	
	function getPagination($user_id)
	{
        if( empty( $this->_pagination ) )
        {
            jimport( 'joomla.html.pagination' );
            $this->_pagination = new JPagination($this->getTotal($user_id), $limitstart, $limit );
        }
        return $this->_pagination;
	}
	
	function _buildQuery($user_id)
	{
		$query = "SELECT * FROM #__wedding_surveys WHERE user_id = {$user_id} ORDER BY created_date DESC";
		return $query;
	}
	
	function getAnswers($survey_id)
	{
		$db = & JFactory::getDbo();
		$query = "SELECT a.id, a.answer, (SELECT COUNT(v.id) FROM #__wedding_survey_votes v WHERE v.survey_id = {$survey_id} AND v.answer_id = a.id LIMIT 1) AS total FROM #__wedding_survey_answers a WHERE a.survey_id = {$survey_id}";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	function getAnswer()
	{
		$db = & JFactory::getDbo();
		$query = 'SELECT * FROM #__wedding_survey_answers WHERE id = '.JRequest::getInt('id').' LIMIT 1';
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function getSurvey()
	{
		$db = & JFactory::getDbo();
		$query = 'SELECT * FROM #__wedding_surveys WHERE id = '.JRequest::getInt('survey_id').' LIMIT 1';
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function save()
	{
		$db = & JFactory::getDbo();
		$data = JRequest::get('post');
		$data['question'] = JRequest::getVar('question', '', '', 'string', JREQUEST_ALLOWHTML);
		
		$row = & $this->getTable('survey');
		$juser = & JFactory::getUser();
		
		if(isset($data['id']) && $data['id'] > 0)
		{
			$row->load($data['id']);
			if($row->user_id != $juser->id)
			{
				$error = 'Bạn không có quyền ghi nội dung này';
				$this->setError($error);
				return false;
			}
		}
		else
		{
			$data['id'] = null;
			$data['created_date'] = date('Y-m-d H:i:s');
		}
		$data['user_id'] = $juser->id;
		
		if(!$row->bind($data))
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		if(!$row->store())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		return true;
	}
	
	function saveanswer()
	{
		$juser = & JFactory::getUser();
		$db = & JFactory::getDbo();		
		$data = JRequest::get('post');
		$row = $this->getTable('answer');
		
		if(isset($data['id']))
		{
			$row->load($data['id']);
			$data['survey_id'] = $row->survey_id;
		}
		
		if( isset($data['survey_id']) )
		{
			$query = "SELECT user_id FROM #__wedding_surveys WHERE id = {$data['survey_id']} LIMIT 1";
			$db->setQuery($query);
			$user_id = $db->loadResult();
			
			if($juser->id != $user_id)
			{
				$this->setError('Bạn không có quyền ghi nội dung này');
				return false;
			}
		}
		else
		{
			$this->setError('Bạn không có quyền ghi nội dung này');
			return false;
		}		
		
		if(!$row->bind($data))
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		if(!$row->store())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		return true;
	}
	
	function correct()
	{
		$id = JRequest::getInt('id');
		$row = & $this->getTable('answer');
		$row->load($id);
		$juser = & JFactory::getUser();
		
		$row2 = $this->getTable('survey');
		$row2->load($row->survey_id);
		
		// delete survey
		if($row2->user_id != $juser->id)
		{
			$this->setError('Bạn không có quyền xóa nội dung này');
			return false;
		}
		
		$row->is_correct = ($row->is_correct == 0 ? 1 : 0);
		
		if(!$row->store())
		{
			$this->setError($row->_db->getErrorMsg());
			return false;
		}
		
		return true;
	}
	
	function publish()
	{
		$id = JRequest::getInt('id');
		$row = & $this->getTable('survey');
		$row->load($id);
		$juser = & JFactory::getUser();
		
		// delete survey
		if($row->user_id != $juser->id)
		{
			$this->setError('Bạn không có quyền sửa nội dung này');
			return false;
		}
		
		$row->published = ($row->published == 0 ? 1 : 0);
		
		if(!$row->store())
		{
			$this->setError($row->_db->getErrorMsg());
			return false;
		}
		
		return true;
	}
	
	function remove()
	{
		$id = JRequest::getInt('id');
		$row = & $this->getTable('survey');
		$row->load($id);
		$juser = & JFactory::getUser();
		
		// delete survey
		if($row->user_id != $juser->id)
		{
			$this->setError('Bạn không có quyền xóa nội dung này');
			return false;
		}
		if(!$row->delete())
		{
			$this->setError($row->_db->getErrorMsg());
			return false;
		}
		//----------------------
		
		// delete answers
		$db = & JFactory::getDbo();
		$query = 'DELETE FROM #__wedding_survey_answers WHERE survey_id = '.$id;
		$db->setQuery($query);
		$db->query();
		//----------------------
		
		return true;
	}
	
	function getSurveyDetails($user_id)
	{
		$limitstart = JRequest::getInt('limitstart');
		
		$db = & JFactory::getDbo();
		$query = "SELECT * FROM #__wedding_surveys WHERE user_id = {$user_id} AND published = 1 ORDER BY created_date DESC LIMIT {$limitstart},1";
		$db->setQuery($query);
		$survey = $db->loadObject();
		
		if($survey)
		{
			$total = $this->getTotal($user_id);
			$limit = 1;
			jimport('joomla.html.pagination');
			$survey->pagination = new JPagination($total, $limitstart, $limit);
			
			$query = "SELECT * FROM #__wedding_survey_answers WHERE survey_id = {$survey->id}";
			$db->setQuery($query);
			$survey->answers = $db->loadObjectList();
		}
		
		return $survey;
	}
	
	function getResultDetails()
	{
		$id = JRequest::getInt('id');
		if($id <= 0) return null;
		
		$db = & JFactory::getDbo();
		$query = "SELECT * FROM #__wedding_surveys WHERE id = {$id} LIMIT 1";
		$db->setQuery($query);
		$survey = $db->loadObject();
		
		if($survey)
		{
			$query = "SELECT a.id, a.answer, (SELECT COUNT(v.id) FROM #__wedding_survey_votes v WHERE v.survey_id = {$id} AND v.answer_id = a.id LIMIT 1) AS total FROM #__wedding_survey_answers a WHERE a.survey_id = {$id}";
			$db->setQuery($query);
			$survey->answers = $db->loadObjectList();
		}
		
		return $survey;
	}
	
	function removeanswer()
	{
		$id = JRequest::getInt('id');
		$juser = & JFactory::getUser();
		
		$row = $this->getTable('answer');
		$row->load($id);
		
		$row2 = $this->getTable('survey');
		$row2->load($row->survey_id);
		
		if($row2->user_id != $juser->id)
		{
			$this->setError('Bạn không có quyền xóa nội dung này');
			return false;
		}
		
		if(!$row->delete())
		{
			$this->setError($row->_db->getErrorMsg());
			return false;
		}
		
		return true;
	}
	
	function dosurvey()
	{
		$survey_id = JRequest::getInt('survey_id');
		$answer_id = JRequest::getInt('answer_id');
		
		// cookie check
		$is_voted = JRequest::getVar('com_wedding_survey_voted_'.$survey_id, 0, 'cookie', 'int');
		if($is_voted != 0)
		{
			$this->setError('Bạn đã thực hiện thăm dò ý kiến này');
			return false;
		}
		
		$time = date('Y-m-d H:i:s');
		$db = & JFactory::getDbo();
		
		// check survey exists
		$query = "SELECT id FROM #__wedding_surveys WHERE id = {$survey_id} LIMIT 1";
		$db->setQuery($query);
		$survey_id = $db->loadResult();

		if(!$survey_id)
		{
			$this->setError('Thăm dò ý kiến ko tồn tại, vui lòng thử lại');
			return false;
		}
		
		// check answer exists and belong to survey
		$query = "SELECT id FROM #__wedding_survey_answers WHERE id = {$answer_id} AND survey_id = {$survey_id} LIMIT 1";
		$db->setQuery($query);
		$answer_id = $db->loadResult();
		
		if(!$answer_id)
		{
			$this->setError('Câu trả lời ko tồn tại, vui lòng thử lại');
			return false;
		}
		
		// store data		
		$row = $this->getTable('vote');
		
		$row->survey_id = $survey_id;
		$row->answer_id = $answer_id;
		$row->created_date = $time;
		
		if(!$row->store())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		// set cookie
		$expired = time() + 7*24*60*60;
		setcookie('com_wedding_survey_voted_'.$survey_id, '1', $expired);
		
		return true;
	}
}
