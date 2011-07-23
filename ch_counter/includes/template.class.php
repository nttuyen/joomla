<?php

/*
 **************************************
 *
 * includes/template.class.php
 * -------------
 * last modified:	2007-01-13
 * -------------
 *
 * project:	chCounter
 * version:	3.1.3
 * copyright:	© 2005 Christoph Bachner
 *               since 2006-21-12 Bert Koern
 * license:	GPL vs2.0 or higher [ see docs/license.txt ]
 * contact:	http://chCounter.org/
 *
 **************************************
*/


class chC_template
{

	var $tags = array();
	var $required_tags = array();
	var $blocks = array();
	var $tpl = '';
	var $parsed_tpl = '';


	function chC_template( $templatefile = '' )
	{
		if( !empty( $templatefile ) )
		{
			if( !file_exists( $templatefile ) )
			{
				print 'Could not find the template file <i>'. $templatefile ."</i>!\n";
				return FALSE;
			}
			$this->load_file( $templatefile );
		}
		return TRUE;
	}


	function load_template( $template )
	{
		$this->tpl .= $template;
	}


	function load_file( $file )
	{
		if( empty( $file ) )
		{
			return FALSE;
		}

		$template = @implode( '', @file( $file ) );
		if( $template == FALSE )
		{
			print 'Could not read the template file!';
			return FALSE;
		}
		$this->tpl .= $template;
	}


	function assign( $input, $value = '', $required = FALSE )
	{
		if( is_array( $input ) )
		{
			foreach( $input as $tag => $value )
			{
				if(empty( $tag ) )
				{
					print 'Tag name ist empty!';
					return FALSE;
				}
				if( $required == TRUE )
				{
					$this->required_tags[$tag] = $value;
				}
				else
				{
					$this->tags[$tag] = $value;
				}
			}
		}
		elseif( is_string( $input ) )
		{
			if( empty( $input ) )
			{
				print 'Tag name ist empty!';
				return FALSE;
			}
			else
			{
				if( $required == TRUE )
				{
					$this->required_tags[$input] = $value;
				}
				else
				{
					$this->tags[$input] = $value;
				}
			}
		}
		else
		{
			return FALSE;
		}
		return TRUE;
	}


	function add_block($block_name, $block_array)
	{
		if( !is_string($block_name) || empty($block_name))
		{
			print 'Block name is not a string or is empty!';
			return FALSE;
		}
		if( !is_array($block_array))
		{
			print 'Block array is not an array!';
			return FALSE;
		}
		$this->blocks[$block_name][] = $block_array;
	}


	function parse( $control_structures = 'WITH_CONTROL_STRUCTURES' )
	{
		if( empty( $this->tpl ) )
		{
			return;
		}

		# blocks
		$tmp_blocknames = array();
		foreach( $this->blocks as $block_name => $block_arrays )
		{
			if( $anzahl = preg_match_all( '/<!-- BEGIN BLOCK '. preg_quote( $block_name, '/' ) .' -->(.*)<!-- END BLOCK '. preg_quote( $block_name, '/' ) .' -->/sU', $this->tpl, $matches ) )
			{
				for( $i = 0; $i < $anzahl; $i++ )
				{
					$block_plus_definition = $matches[0][$i];
					$block = $matches[1][$i];

					if( is_int( strpos( $block, '<!-- IF' ) ) )
					{
						$parse_control_structures = TRUE;
					}

					$parsed_block = '';
					foreach( $block_arrays as $block_array )
					{
						$tmp = $block;
						if( isset( $parse_control_structures ) )
						{
							$tmp = $this->_parse_control_structures( $tmp, array_merge( $block_array, $this->tags, $this->required_tags ) );
						}
						foreach( $block_array as $tag_name => $tag_value )
						{
							$tmp = str_replace( '{'.$tag_name.'}', $tag_value, $tmp );
						}
						$parsed_block .= $tmp;
					}
					$this->tpl = str_replace( $block_plus_definition, $parsed_block, $this->tpl );
					$tmp_blocknames[] = $block_name;
					unset( $parse_control_structures );
				}
			}
		}
		if( count( $this->blocks ) > 0 )
		{
			$this->tpl = preg_replace( "/<!-- (BEGIN|END) BLOCK (". implode( '|', $tmp_blocknames ) .") -->/", '', $this->tpl );
		}

		# unbenutze blöcke entfernen
		$this->tpl = preg_replace( "/<!-- BEGIN BLOCK ([a-zA-Z0-9_-]+) -->.*<!-- END BLOCK \\1 -->(\r\n|\r|\n)?/msU", '', $this->tpl );
		  


		# single tags
		foreach( $this->required_tags as $tag_name => $tag_value )
		{
			if( !is_int( strpos( $this->tpl, $tag_name ) ) )
			{
				print 'Could not find tag <i>'.$tag_name.'</i> in the template file!';
				return FALSE;
			}
			else
			{
				$this->tpl = str_replace( '{'.$tag_name.'}', $tag_value, $this->tpl );
			}
		}
		foreach( $this->tags as $tag_name => $tag_value )
		{
			$this->tpl = str_replace( '{'.$tag_name.'}', $tag_value, $this->tpl );
		}


		# if & else
		if( $control_structures != 'WITHOUT_CONTROL_STRUCTURES' )
		{
			$this->tpl = $this->_parse_control_structures(
				$this->tpl,
				array_merge( $this->tags, $this->required_tags ),
				$this->blocks
			);
		}


		$this->parsed_tpl = $this->tpl;
		$this->tpl = '';
	}


	function print_template()
	{
		if( !empty( $this->tpl ) )
		{
			$this->parse();
		}
		print $this->parsed_tpl;
	}


	function get_tpl_as_var()
	{
		if( !empty( $this->tpl ) )
		{
			$this->parse();
		}
		return $this->parsed_tpl;
	}


	function free()
	{
		$this->tpl = '';
		$this->parsed_tpl = '';
		$this->tags = array();
		$this->required_tags = array();
		$this->blocks = array();
	}






	function _parse_control_structures( $tpl, $vars, $blocks = array() )
	{
		if( $matchnumber = preg_match_all( '/<!-- IF (!?)((BLOCK )?)([_a-zA-Z0-9\-]+) -->(.*)((<!-- ELSEIF !\(\\1\\2\\4\) -->)(.*))?<!-- ENDIF \\1\\2\\4 -->/msU', $tpl, $matches ) )
		{
			for( $i = 0; $i < $matchnumber; $i++ )
			{
				if( !empty( $matches[2][$i] ) )
				{
					$code = 'if( '.$matches[1][$i].'isset($blocks[\''.$matches[4][$i].'\']) )'."\n";
				}
				else
				{
					$code = 'if( '.$matches[1][$i].'( isset($vars[\''.$matches[4][$i].'\']) ) )'."\n";
				}
				$code .= '{ $tpl = str_replace( $matches[0][$i], $this->_parse_control_structures( $matches[5][$i], $vars, $blocks ), $tpl ); }'."\n";
				$code .= ' else '."\n";
				$code .= '{ $tpl = str_replace( $matches[0][$i], !empty($matches[7][$i]) ? $this->_parse_control_structures( $matches[8][$i], $vars, $blocks ) : \'\', $tpl ); }';
				eval( $code );
			}
		}         
		return $tpl;
	}
}

?>
