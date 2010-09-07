<?php
/**
 * My Framework
 *
 * @category   My
 * @package    My_View
 * @version    $Id: Datagrid.php 3992 2010-08-22 03:10:31Z calugarn $
 */

class My_View_Helper_Datagrid extends Zend_View_Helper_Abstract
{
	/**
     * Render the datagrid.  This checks if $view->datagrid is set and,
     * if so, uses that.
     *
     * @param  My_Datagrid (Optional) $datagrid
     * @return string
     * @throws Exception
     */
    public final function datagrid(My_Datagrid $datagrid = null)
    {
        if ($datagrid === null) {
            if (isset($this->view->datagrid) and $this->view->datagrid !== null and $this->view->datagrid instanceof My_Datagrid) {
                $datagrid = $this->view->datagrid;
            } else {
                throw new Exception('No datagrid instance provided or incorrect type');
            }
        }
        
        if ($datagrid->getDataMode()) {
        	return $this->renderData($datagrid);
        }
        return $this->renderSetup($datagrid);
    }

    /**
     * Setup the JS and render the container for the jqGrid.  This checks if $view->paginator is set and,
     * if so, uses that.  Haven't worked out the details on the other parameters.
     *
     * @param My_Datagrid
     * @return string
     */
    public final function renderSetup(My_Datagrid $datagrid)
    {
        foreach ($datagrid->getStylesheets() as $stylesheet) {
        	$this->view->jQuery()->addStylesheet($stylesheet);
        }
		$this->view->jQuery()->addJavascriptFile('/js/jqGrid/i18n/grid.locale-en.js');
        $this->view->jQuery()->addJavascriptFile('/js/jqGrid/jquery.jqGrid.min.js');
        
        $this->view->jQuery()->onLoadCaptureStart();
		?>
			jQuery.extend(
				$.fn.fmatter,
				{
	    			checkboxEnhancedFmatter : function(cellvalue, options, rowdata) {
	    				var formatoptions = options.colModel.formatoptions;
	    				var disabled = '';
						if (formatoptions.disabled === true) {
							disabled = "disabled";
						}
						var onchange = '';
						if (!isEmpty(formatoptions.onchange)) {
							onchange = ' onchange="' + formatoptions.onchange + '(this, \'' + options.rowId + '\')"';
						}						
						if (isEmpty(cellvalue) || isUndefined(cellvalue)) {
							cellvalue = $.fn.fmatter.defaultFormat(cellvalue, formatoptions);
						}
						cellvalue = cellvalue + "";
						cellvalue = cellvalue.toLowerCase();
						var d = cellvalue.search(/(false|0|no|off)/i) < 0 ? " checked='checked' " : "";
						return '<input type="checkbox" ' + d + ' value="' + cellvalue + '" offval="no" ' + disabled + onchange + '/>';
					}
				}
			);
			
			jQuery.extend(
				$.fn.fmatter.checkboxEnhancedFmatter,
				{
					unformat : function(cellvalue, options, cell) {
						var editoptions = (options.colModel.editoptions) 
							? options.colModel.editoptions.value.split(":")
							: [ "Yes", "No" ];
						return $("input", cell).attr("checked") ? editoptions[0] : editoptions[1];
					}
				}
			);
			
		<?php 
		if ($datagrid->getTableDnD()) {
			$this->view->jQuery()->addJavascriptFile('/js/plugins/jquery.tablednd.js');
		?>
			jQuery("#<?=$datagrid->getGridSelector() ?>").tableDnD({
				scrollAmount:0,
				onDrop: function(table, row){ <?=$datagrid->getTableDnDOnDrop() ?>},
			});
		<?php 
		}
		?>
			jQuery("#<?=$datagrid->getGridSelector() ?>").jqGrid({
				url: '<?=$datagrid->getUrl() ?>',
				datatype: '<?=$datagrid->getDatatype() ?>',
				mtype: '<?=$datagrid->getMtype() ?>',
				multiselect: <?=($datagrid->getMultiselect())?'true':'false' ?>,
				search: true,
				colModel: [<?=$this->_getColModel($datagrid) ?>], 
				pager: jQuery('#<?=$datagrid->getPagerSelector() ?>'),
				pgbuttons: <?=($datagrid->getPgbuttons())?'true':'false' ?>,
				pginput: <?=($datagrid->getPginput())?'true':'false' ?>,
				rowNum: <?=$datagrid->getItemCountPerPage() ?>,
				rowList: [<?=implode(',', $datagrid->getRowList()) ?>],
				sortname: '<?=$datagrid->getSortname() ?>',
				sortorder: '<?=$datagrid->getSortorder() ?>',
				viewrecords: <?=($datagrid->getViewrecords())?'true':'false' ?>,
				caption: '<?=$datagrid->getCaption() ?>',
				<?=($datagrid->getAutowidth())?'autowidth: true':'width: '.$datagrid->getWidth() ?>,
				height: '<?=$datagrid->getHeight() ?>',
				gridComplete: function(){ <?=$datagrid->getGridComplete() ?>},
				loadBeforeSend: function(xhr){ <?=$datagrid->getLoadBeforeSend() ?>},
				loadComplete: function(xhr){ <?=$datagrid->getLoadComplete() ?>},
				loadError: function(xhr, status, error){ <?=$datagrid->getLoadError() ?>},
				ondblClickRow: function(rowid, iRow, iCol, e){ <?=$datagrid->getOnDblClickRow() ?>},
				onSelectRow: function(rowid, status){ <?=$datagrid->getOnSelectRow() ?>},
				<?php
				$serializeGridData = $datagrid->getSerializeGridData();
				if (!empty($serializeGridData)) {
                    echo 'serializeGridData: function(postData){ '.$serializeGridData.' },';
				} ?>
				treeGrid: <?=($datagrid->getTreeGrid())?'true':'false' ?>,
				treeGridModel: '<?=$datagrid->getTreeGridModel() ?>',
				treeIcons: <?=$this->_arrayToJqGridHelper($datagrid->getTreeIcons()) ?>,
				ExpandColumn: '<?=$datagrid->getExpandColumn() ?>',
				ExpandColClick: <?=($datagrid->getExpandColClick())?'true':'false' ?>,
				cellEdit: <?=($datagrid->getCellEdit())?'true':'false' ?>,
				cellsubmit: '<?=$datagrid->getCellSubmit() ?>',
				cellurl: '<?=$datagrid->getCellUrl() ?>',
				subGrid: <?=($datagrid->getSubGrid())?'true':'false' ?>,
				subGridRowExpanded: function(pID, id){ <?=$datagrid->getSubGridRowExpanded() ?>},
				subGridRowColapsed: function(pID, id){ <?=$datagrid->getSubGridRowColapsed() ?>}
			});
		<?php 
		if ($datagrid->getShowNavigator()) {
		?>
			jQuery("#<?=$datagrid->getGridSelector() ?>").jqGrid(
				'navGrid',
				'#<?=$datagrid->getPagerSelector() ?>',
				{<?=$datagrid->getNavigatorOptions()?>}, // options
				{<?=$datagrid->getNavigatorEditOptions()?>}, // edit options
				{<?=$datagrid->getNavigatorAddOptions()?>}, // add options
				{<?=$datagrid->getNavigatorDeleteOptions()?>}, // del options
				{<?=$datagrid->getNavigatorSearchOptions()?>}, // search options
				{<?=$datagrid->getNavigatorViewOptions()?>} // view options
			);
		<?php
			$navigatorCustomButtons = $datagrid->getNavigatorCustomButtons();
			if (!empty($navigatorCustomButtons)) {
				foreach ($navigatorCustomButtons as $navigatorCustomButton) {
				?>
					jQuery("#<?=$datagrid->getGridSelector() ?>").jqGrid(
						'navButtonAdd',
						'#<?=$datagrid->getPagerSelector() ?>',{
						caption:<?=isset($navigatorCustomButton['caption'])?"'".$navigatorCustomButton['caption']."'":"''" ?>,
						buttonicon:<?=isset($navigatorCustomButton['buttonicon'])?"'".$navigatorCustomButton['buttonicon']."'":"'ui-icon-carat-1-n'" ?>,
						onClickButton:<?=isset($navigatorCustomButton['onClickButton'])?$navigatorCustomButton['onClickButton']:"''" ?>,
						position:<?=isset($navigatorCustomButton['position'])?"'".$navigatorCustomButton['position']."'":"'last'" ?>,
						title:<?=isset($navigatorCustomButton['title'])?"'".$navigatorCustomButton['title']."'":"''" ?>,
						cursor:<?=isset($navigatorCustomButton['cursor'])?"'".$navigatorCustomButton['cursor']."'":"'pointer'" ?>
					});
				<?php
				}
			}
		}
		if ($datagrid->getShowFilterToolbar()) { 
		?>
			jQuery("#<?=$datagrid->getGridSelector() ?>").jqGrid('filterToolbar');
		<?php
		}
        if ($datagrid->getSortableRows()) {
		?> 
			jQuery("#<?=$datagrid->getGridSelector() ?>").sortableRows({
			    <?php
			    foreach ($datagrid->getSortableRowsOptions() as $key=>$value) {
			        echo $key . ':' . $value;
			    }
			    ?>	
			});
		<?php
		}
		$this->view->jQuery()->onLoadCaptureEnd();
		
        return '<div id="'.$datagrid->getSearchSelector().'"></div>
<table id="'.$datagrid->getGridSelector().'" class="scroll"></table> 
<div id="'.$datagrid->getPagerSelector().'" class="scroll" style="text-align:center;"></div>';
    }
    
    protected function _getColNames(My_Datagrid $datagrid)
    {
    	$colNames = $datagrid->getColNames();
    	if (is_array($colNames) && !empty($colNames)) {
    		return $colNames;
    	}
    	
    	$itemKeys = array_keys($datagrid->getItem(1));
    	$return = array();
    	foreach ($itemKeys as $itemKey) {
    		switch ($itemKey) {
    			case 'id':
    				$return[] = strtoupper($itemKey);
    				break;
    			default:
    				$return[] = ucfirst(str_replace('_', ' ', $itemKey));
    		}
    		
    	}
    	return $return;
    }
    
    protected function _getColModel(My_Datagrid $datagrid)
    {
    	$return = array();
    	
    	$colModel = $datagrid->getColModel();
    	if (is_array($colModel) && !empty($colModel)) {
    		foreach ($colModel as $column) {
				$return[] = $this->_arrayToJqGridHelper($column);
    		}
    	} else {
    		// try to make colModel from the first item in the result    		
	    	$itemOne = $datagrid->getItem(1);
	    	if (!empty($itemOne)) {
		    	$itemKeys = array_keys($itemOne);
		    	foreach ($itemKeys as $itemKey) {
		    		switch ($itemKey) {
		    			case 'id':
		    				$label = strtoupper($itemKey);
		    				break;
		    			default:
		    				$label = ucfirst(str_replace('_', ' ', $itemKey));
		    		}
					$return[] = "{label:'$label', name:'$itemKey', index:'$itemKey'}";
				}
	    	}
    	}
    	
		return implode(" , ", $return);
    }
    
    protected function _arrayToJqGridHelper(array $column)
    {
    	$temp = array();
    	foreach ($column as $key => $value) {
    		if (is_array($value)) {
    			$value = $this->_arrayToJqGridHelper($value);
    		} elseif (is_string($value)) {
    			$value = "'$value'";
    		} elseif (is_bool($value)) {
    			$value = ($value)?'true':'false';
    		}
    		$temp[] = "$key:$value";
    	}
    	return '{'.implode(', ', $temp).'}';
    }
    
    /**
     * Render the data for a jqGrid.  This checks if $view->paginator is set and,
     * if so, uses that.  Haven't worked out the details on the other parameters.
     *
     * @param  Zend_Paginator (Optional) $paginator
     * @param  array $options (Optional) options for the datagrid
     * @return string
     */
    public function renderData(My_Datagrid $datagrid)
    {
        switch ($datagrid->getDataType()) {
        	case 'json':
        		return $this->_renderDataJson($datagrid);
 		       	break;
        	case 'xml':
        		return $this->_renderDataXml($datagrid);
        		break;
        	default:
        		throw new Exception('My_View_Helper_Datagrid - Unsupported datatype for renderData()');
        		break;
        }
    }
    
    protected function _renderDataJson(My_Datagrid $datagrid)
    {
    	$return = new stdClass();
    	$return->page = $datagrid->getCurrentPageNumber(); // current page
		$return->total = $datagrid->count(); // total pages
		$return->records = $datagrid->getTotalItemCount(); // total records
		$return->userdata = $datagrid->getUserData(); // custom data for the page
		$i=0;
		$rowId = $datagrid->getRowId();
		$colModel = $datagrid->getColModel();
		foreach ($datagrid as $item) {
			if (is_object($item)) {
				$return->rows[$i]['id'] = $item->$rowId;
			} elseif (is_array($item)) {
			    $return->rows[$i]['id'] = $item[$rowId];
			} else {
				throw new Exception('My_View_Helper_Datagrid expects array of objects or multi-dimensional array');
			}
		    $cell = array();
			if (is_array($colModel) && !empty($colModel)) {
				foreach ($colModel as $key => $model) {
					if (is_object($item)) {
						$value = $item->$key;
					} elseif (is_array($item)) {
					    $value = $item[$key];
					} else {
						throw new Exception('My_View_Helper_Datagrid expects array of objects or multi-dimensional array');
					}
					if (isset($model['viewHelper'])) {
						$viewHelper = $model['viewHelper'];
						$cellData = $this->view->$viewHelper($value);
					} else {
						$cellData = $this->view->escape($value);	
					}
					$cell[] = $cellData;
				}
			} else {
				if (is_array($item)) {
					foreach ($item as $key => $value) {
						$cell[] = $this->view->escape($value);
					}
				} else {
					throw new Exception('My_View_Helper_Datagrid expects multi-dimensional array if no colModel is provided');
				}
			}
		    $return->rows[$i]['cell'] = $cell;
		    $i++;
		} 
		return Zend_Json::encode($return);
    	
    }
    
    protected function _renderDataXml(My_Datagrid $datagrid)
    {
    	$front = Zend_Controller_Front::getInstance();
    	$rowId = $datagrid->getRowId();
    	$colModel = $datagrid->getColModel();
    	$front->getResponse()->setHeader('Content-type', 'text/xml');
    	$return = '<?xml version="1.0" encoding="utf-8"?>
		<rows>
			<page>' . $datagrid->getCurrentPageNumber() . '</page> 
			<total>' . $datagrid->count() . '</total>
			<records>' . $datagrid->getTotalItemCount() . '</records>';
    	    foreach ($datagrid->getUserData() as $key => $value) {
    	        $return .= '
    	        <userdata name="'.$key.'">'.$value.'</userdata>';
    	    }
			foreach ($datagrid as $item) {
				if (is_object($item)) {
					$return .= '
					<row id="'.$item->$rowId.'">';
				} elseif (is_array($item)) {
					$return .= '
					<row id="'.$item[$rowId].'">';
				} else {
					throw new Exception('My_View_Helper_Datagrid expects array of objects or multi-dimensional array');
				}
				if (is_array($colModel) && !empty($colModel)) {
					foreach ($colModel as $key => $model) {
						if (is_object($item)) {
							$value = $item->$key;
						} elseif (is_array($item)) {
						    $value = $item[$key];
						} else {
							throw new Exception('My_View_Helper_Datagrid expects array of objects or multi-dimensional array');
						}
						if (isset($model['viewHelper'])) {
							$viewHelper = $model['viewHelper'];
							$cellData = $this->view->$viewHelper($value);
						} else {
							$cellData = $this->view->escape($value);	
						}
						$return .= '
	    				<cell><![CDATA['.$cellData.']]></cell>';
					}
				} else {
					if (is_array($item)) {
						foreach ($item as $key => $value) {
							$return .= '
		    				<cell><![CDATA['.$this->view->escape($value).']]></cell>';
						}
					} else {
						throw new Exception('My_View_Helper_Datagrid expects multi-dimensional array if no colModel is provided');
					}
				}
				$return .= '
				</row>';
			}
		$return .= '
		</rows>';
        return $return;
    }
    
}
