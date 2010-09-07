<?php
/**
 * My Framework
 *
 * @category   My
 * @package    My_Datagrid
 * @version    $Id: Datagrid.php 440 2009-06-23 18:09:30Z calugarn $
 */

class My_Datagrid extends Zend_Paginator
{
	/**
	 * The view helper used to render
	 * 
	 * @var string
	 */
	protected $_viewHelper = 'datagrid';
	
	/**
     * The field from the paginator that will be used as the row id
     * 
     * @var string
     */
    protected $_rowId = 'id';
    
    /**
     * The stylesheets to be loaded by the renderSetup function
     * 
     * @var array
     */
    protected $_stylesheets = array(
    	'/js/jqGrid/css/ui.jqgrid.css',
    );
    
    /**
     * The URL for the jqGrid
     * 
     * @var string
     */
    protected $_url;
    
    /**
     * The datatype for the jqGrid
     * 'xml' - SUPPORTED
     * 'json' - SUPPORTED (default)
     * 'clientSide' - NOT SUPPORTED
     * 'local' - NOT SUPPORTED
     * 'xmlstring' - NOT SUPPORTED
     * 'jsonstring' - NOT SUPPORTED
     * 'function (...)' - NOT SUPPORTED
     * 
     * @var string
     */
    protected $_datatype = 'json';
    
    /**
     * GET / POST
     * 
     * @var string
     */
    protected $_mtype = 'GET';
    
    /**
     * multi selection of rows enabled
     * 
     * @var boolean
     */
    protected $_multiselect = false;
    
    /**
     * Will be shown as options for number of items per page
     *
     * @var array
     */
    protected $_rowList = array(10,20,30,40,50);
    
    /**
     * The default sort column
     *
     * @var string
     */
    protected $_sortname = 'id';
    
	/**
	 * The default sort order
	 * 
	 * @var string
	 */
    protected $_sortorder = 'asc';
    
    /**
     * Show the total number of records in pager bar
     * 
     * @var boolean
     */
    protected $_viewrecords = true;
    
    /**
     * the caption for the grid header row
     * 
     * @var string
     */
    protected $_caption = 'Default Caption (to change pass as an option)';
    
    /**
     * the unique id of the table that will hold the grid
     *
     * @var string
     */
    protected $_gridSelector = 'list';

    /**
     * the unique id of the div that will hold the pager
     *
     * @var string
     */
    protected $_pagerSelector = 'pager';
    
    /**
     * the unique id of the div that will hold the search
     * 
     * @var string
     */
    protected $_searchSelector = 'search';
    
    /**
     * use autowidth feature
     * 
     * @var boolean
     */
    protected $_autowidth = true;
    
    /**
     * width of the grid
     *
     * @var int
     */
    protected $_width = 890;
    
    /**
     * height of the grid
     *
     * @var string
     */
    protected $_height = 'auto';
    
    /**
     * Render data if true
     * 
     * @var boolean
     */
    protected $_dataMode = false;
    
    /**
     * The column model
     * 
     * @var array
     */
    protected $_colModel = array();
    
    /**
     * Make the grid Drag and Drop
     * 
     * @var boolean
     */
    protected $_tableDnD = false;
    
    /**
     * function contents that will be excuted when a row is dropped
     * 
     * @var string
     */
    protected $_tableDnDOnDrop = '';
    
    /**
     * Make the grid rows sortable
     * 
     * @var boolean
     */
    protected $_sortableRows = false;
    
    /**
     * Options that are passed to the jQuery UI Sortable
     * 
     * @var array
     */
    protected $_sortableRowsOptions = array();
    
    /**
     * show the filter toolbar
     * 
     * @var boolean
     */
    protected $_showFilterToolbar = false;
    
    /**
     * show the pager buttons
     * 
     * @var boolean
     */
    protected $_pgbuttons = true;
    
    /**
     * show the pager input
     * 
     * @var boolean
     */
    protected $_pginput = true;
    
    /**
     * show the navigator in the pager row
     * 
     * @var boolean
     */
    protected $_showNavigator = false;
    
    /**
     * the options for the navigator
     * 
     * @var string
     */
    protected $_navigatorOptions = '';
    
    /**
     * the options for the navigator
     * 
     * @var string
     */
    protected $_navigatorEditOptions = '';
    
    /**
     * the options for the navigator
     * 
     * @var string
     */
    protected $_navigatorAddOptions = '';
    
    /**
     * the options for the navigator
     * 
     * @var string
     */
    protected $_navigatorDeleteOptions = '';
    
    /**
     * the options for the navigator
     * 
     * @var string
     */
    protected $_navigatorSearchOptions = '';
    
    /**
     * the options for the navigator
     * 
     * @var string
     */
    protected $_navigatorViewOptions = '';
    
    /**
     * custom buttons for the navigator
     * 
     * @var array
     */
    protected $_navigatorCustomButtons = array();
    
    /**
     * Show plus sign to expand row into a subgrid
     * 
     * @var boolean
     */
    protected $_subGrid = false;
    
    /**
     * The URL to get the subGrid data
     * 
     * @var string
     */
    protected $_subGridUrl = '';
    
    /**
     * event executed when the subgrid is enabled and is executed when the user clicks on the plus icon
     * 
     * @var string
     */
    protected $_subGridRowExpanded = '';
    
    /**
     * event executed when the user clicks on the minus icon
     * 
     * @var string
     */
    protected $_subGridRowColapsed = '';
    
    /**
     * event executed when the grid data is laoded
     * 
     * @var string
     */
    protected $_gridComplete = '';
    
    /**
     * event executed before the XMLHttpRequest object is sent...allows modification i.e. custom headers
     * 
     * @var string 
     */
    protected $_loadBeforeSend = '';
    
    /**
     * event executed immediately after every server request. 
     * 
     * @var string
     */
    protected $_loadComplete = '';
    
    /**
     * event executed if the AJAX request fails
     * 
     * @var string
     */
    protected $_loadError = '';
    
    /**
     * event executed when a row is double clicked
     * 
     * @var string
     */
    protected $_onDblClickRow = '';
    
    /**
     * event executed when a row is clicked
     * 
     * @var string
     */
    protected $_onSelectRow = '';
    
    /**
     * event executed immediately before the AJAX request
     * must return the serialized data
     * 
     * @var string
     */
    protected $_serializeGridData = '';
    
    /**
     * render as a tree grid
     * 
     * @var boolean
     */
    protected $_treeGrid = false;
    
    /**
     * tree grid model
     * 
     * @var string
     */
    protected $_treeGridModel = 'nested';
    
    protected $_treeIcons = array(
    	'plus'=>'ui-icon-triangle-1-e',
    	'minus'=>'ui-icon-triangle-1-s',
    	'leaf'=>'ui-icon-radio-off',
    );
    
    /**
     * the column to expand for tree grid
     * 
     * @var string
     */
    protected $_expandColumn = '';
    
    /**
     * expand when click on text too
     * 
     * @var string
     */
    protected $_expandColClick = true;
    
    /**
     * allow editing of individual cells
     * 
     * @var boolean
     */
    protected $_cellEdit = false;
    
    /**
     * the cell submit method ('remote', 'clientArray')
     * 
     * @var string
     */
    protected $_cellSubmit = 'remote';
    
    /**
     * the cell edit / submit url
     * 
     * @var string
     */
    protected $_cellUrl = '';
    
    /**
     * the userData that will be returned in data mode
     * 
     * @var array
     */
    protected $_userData = array();
	
	/**
     * Call the public setter methods by iterating through an array of options
     *
     * @throws My_Exception
     */
    public function setOptions($options)
    {
    	if ($options instanceof Zend_Config) {
    		$options = $options->toArray();
    	}
    	if (is_array($options)) {
	    	foreach ($options as $key => $value) {
	            $normalized = ucfirst($key);
	            $method = 'set' . $normalized;
	            if (method_exists($this, $method)) {
	                $this->$method($value);
	            }
	            //TODO: ignore options that aren't supported or set attribs of something?
	        }
        }
    }
    
    /**
     * Set the view helper
     * 
     * @param $viewHelper
     * @return My_Datagrid
     */
    public function setViewHelper($viewHelper)
    {
		$this->_viewHelper = (string)$viewHelper;
		return $this;
    }
    
    /**
     * This should be a column in the dataset that will be used to id the row in the resulting grid
     * 
     * @param $rowId
     * @return My_Datagrid
     */
    public function setRowId($rowId)
    {
    	$this->_rowId = (string)$rowId;
    	return $this;
    }
    
    /**
     * Get the rowId
     * 
     * @return string
     */
    public function getRowId()
    {
    	return $this->_rowId;
    }
    
    /**
     * The stylesheets for rendering the grid
     * 
     * @return array
     */
    public function getStylesheets()
    {
    	return $this->_stylesheets;
    }
    
    /**
     * Set the URL for the jqGrid
     *
     * @param string $url
     * @return My_View_Helper_Datagrid
     */
    public function setUrl($url)
    {
    	$this->_url = (string)$url;
    	return $this;
    }
    
    /**
     * Get the URL for the jqGrid
     * 
     * @return string
     */
    public function getUrl()
    {
    	return $this->_url;
    }
    
    /**
     * Set the Datatype for the jqGrid
     *
     * @param string $datatype
     * @return My_View_Helper_Datagrid
     */
    public function setDatatype($datatype)
    {
    	$this->_datatype = (string)$datatype;
    	return $this;
    }
    
    /**
     * Get the Datatype for the jqGrid
     * 
     * @return string
     */
    public function getDatatype()
    {
    	return $this->_datatype;
    }
    
    /**
     * tells us how to make the ajax call: either 'GET' or 'POST'
     *
     * @param string $mtype
     * @return My_View_Helper_Datagrid
     */
    public function setMtype($mtype)
    {
    	$this->_mtype = (string)$mtype;
    	return $this;
    }
    
    /**
     * Get the request type
     * 
     * @return string
     */
    public function getMtype()
    {
    	return $this->_mtype;
    }
    
	/**
     * get multiselect
     *
     * @param string $multiselect
     * @return My_View_Helper_Datagrid
     */
    public function setMultiselect($multiselect)
    {
    	$this->_multiselect = (bool)$multiselect;
    	return $this;
    }
    
    /**
     * Get multiselect
     * 
     * @return string
     */
    public function getMultiselect()
    {
    	return $this->_multiselect;
    }
    
    /**
     * an array to construct a select box element in the pager in which we can change the number of the visible rows.
     *
     * @param array $rowList
     * @return My_View_Helper_Datagrid
     */
    public function setRowList(array $rowList)
    {
    	$this->_rowList = $rowList;
    	return $this;
    }
    
    /**
     * Get the array that represents the choices of the number of visible records
     * 
     * @return array
     */
    public function getRowList()
    {
    	return $this->_rowList;
    }
    
    /**
     * sets the initial sorting column.
     *
     * @param string $sortname
     * @return My_View_Helper_Datagrid
     */
    public function setSortname($sortname)
    {
    	$this->_sortname = (string)$sortname;
    	return $this;
    }
    
    /**
     * Get the initial sorting column
     * 
     * @return string
     */
    public function getSortname()
    {
    	return $this->_sortname;
    }
    
    /**
     * sets the initial sort order
     *
     * @param string $sortorder
     * @return My_View_Helper_Datagrid
     */
    public function setSortorder($sortorder)
    {
    	$this->_sortorder = (string)$sortorder;
    	return $this;
    }
    
    /**
     * Get the initial sort order
     * 
     * @return string
     */
    public function getSortorder()
    {
    	return $this->_sortorder;
    }
    
    /**
     * defines whether we want to display the number of total records from the query in the pager bar
     * 
     * @param boolean $viewrecords
     * @return My_View_Helper_Datagrid
     */
    public function setViewrecords($viewrecords)
    {
    	$this->_viewrecords = (boolean)$viewrecords;
    	return $this;
    }
    
    /**
     * Get the flag whether or not to show the total number of records
     * 
     * @return boolean
     */
    public function getViewrecords()
    {
    	return $this->_viewrecords;
    }
    
    /**
     * sets the caption in the header row of the grid
     *
     * @param string $caption
     * @return My_View_Helper_Datagrid
     */
    public function setCaption($caption)
    {
    	$this->_caption = (string)$caption;
    	return $this;
    }
    
    /**
     * Get the caption for the grid
     * 
     * @return strubg
     */
    public function getCaption()
    {
    	return $this->_caption;
    }
    
    /**
     * sets the id of the table that will hold the grid
     *
     * @param string $gridSelector
     * @return My_View_Helper_Datagrid
     */
    public function setGridSelector($gridSelector)
    {
    	$this->_gridSelector = (string)$gridSelector;
    	return $this;
    }
    
    /**
     * Get the id of the table
     * 
     * @return string
     */
    public function getGridSelector()
    {
    	return $this->_gridSelector;
    }
    
	/**
     * sets the id of the div that will hold the pager
     *
     * @param string $pagerSelector
     * @return My_View_Helper_Datagrid
     */
    public function setPagerSelector($pagerSelector)
    {
    	$this->_pagerSelector = (string)$pagerSelector;
    	return $this;
    }
    
    /**
     * Get the id of the div for the pager
     * 
     * @return string
     */
    public function getPagerSelector()
    {
    	return $this->_pagerSelector;
    }
    
	/**
     * sets the id of the div that will hold the search
     *
     * @param string $searchSelector
     * @return My_View_Helper_Datagrid
     */
    public function setSearchSelector($searchSelector)
    {
    	$this->_searchSelector = (string)$searchSelector;
    	return $this;
    }
    
    /**
     * Get the id of the div for the search
     * 
     * @return string
     */
    public function getSearchSelector()
    {
    	return $this->_searchSelector;
    }
    
	/**
     * set autowidth
     *
     * @param boolean $autowidth
     * @return My_Datagrid
     */
    public function setAutowidth($autowidth = true)
    {
    	$this->_autowidth = (bool)$autowidth;
    	return $this;
    }
    
    /**
     * get autowidth
     * 
     * @return boolean
     */
    public function getAutowidth()
    {
    	return $this->_autowidth;
    }
    
    /**
     * the width of the grid
     *
     * @param int $width
     * @return My_View_Helper_Datagrid
     */
    public function setWidth($width)
    {
    	$this->_width = (int)$width;
    	return $this;
    }
    
    /**
     * the width of the grid
     * 
     * @return int
     */
    public function getWidth()
    {
    	return $this->_width;
    }
    
    /**
     * the height of the grid
     *
     * @param string $height
     * @return My_View_Helper_Datagrid
     */
    public function setHeight($height)
    {
    	$this->_height = (string)$height;
    	return $this;
    }
    
    /**
     * the height of the grid
     * 
     * @return string
     */
    public function getHeight()
    {
    	return $this->_height;
    }
    
    /**
     * Render data if true
     * 
     * @param boolean $dataMode
     * @return My_Datagrid
     */
    public function setDataMode($dataMode = true)
    {
    	$this->_dataMode = $dataMode;
    	return $this;
    }
    
    /**
     * Get the dataMode flag
     * 
     * @return boolean
     */
    public function getDataMode()
    {
    	return $this->_dataMode;
    }
    
	/**
     * Set the column model
     * 
     * @param array $colModel
     * @return My_Datagrid
     */
    public function setColModel(array $colModel = array())
    {
    	$this->_colModel = $colModel;
    	return $this;
    }
    
    /**
     * Get the column model
     * 
     * @return array
     */
    public function getColModel()
    {
    	return $this->_colModel;
    }
    
	/**
     * Make rows drag and drop
     * 
     * @param boolean $tableDnD
     * @return My_Datagrid
     */
    public function setTableDnD($tableDnD = true)
    {
    	$this->_tableDnD = (bool)$tableDnD;
    	return $this;
    }
    
    /**
     * Get the tableDnD flag
     * 
     * @return boolean
     */
    public function getTableDnD()
    {
    	return $this->_tableDnD;
    }
    
	/**
     * Set tableDnDOnDrop function contents
     * 
     * @param string $tableDnDOnDrop
     * @return My_Datagrid
     */
    public function setTableDnDOnDrop($tableDnDOnDrop = '')
    {
    	$this->_tableDnDOnDrop = (string)$tableDnDOnDrop;
    	return $this;
    }
    
    /**
     * Get tableDnDOnDrop function contents
     * 
     * @return string
     */
    public function getTableDnDOnDrop()
    {
    	return $this->_tableDnDOnDrop;
    }
    
	/**
     * Make rows sortable
     * 
     * @param boolean $sortableRows
     * @return My_Datagrid
     */
    public function setSortableRows($sortableRows = true)
    {
    	$this->_sortableRows = (bool)$sortableRows;
    	return $this;
    }
    
    /**
     * Get the sortableRows flag
     * 
     * @return boolean
     */
    public function getSortableRows()
    {
    	return $this->_sortableRows;
    }
    
	/**
     * Set the sortable rows options
     * 
     * @param array $sortableRowsOptions
     * @return My_Datagrid
     */
    public function setSortableRowsOptions(array $sortableRowsOptions = array())
    {
    	$this->_sortableRowsOptions = $sortableRowsOptions;
    	return $this;
    }
    
    /**
     * Get the sortable rows options
     * 
     * @return array
     */
    public function getSortableRowsOptions()
    {
    	return $this->_sortableRowsOptions;
    }
    
	/**
     * Show filterToolbar if true
     * 
     * @param boolean $showFilterToolbar
     * @return My_Datagrid
     */
    public function setShowFilterToolbar($showFilterToolbar = true)
    {
    	$this->_showFilterToolbar = (bool)$showFilterToolbar;
    	return $this;
    }
    
    /**
     * Get the showFilterToolbar flag
     * 
     * @return boolean
     */
    public function getShowFilterToolbar()
    {
    	return $this->_showFilterToolbar;
    }
    
	/**
     * Show pager buttons if true
     * 
     * @param boolean $pgbuttons
     * @return My_Datagrid
     */
    public function setPgbuttons($pgbuttons = true)
    {
    	$this->_pgbuttons = (bool)$pgbuttons;
    	return $this;
    }
    
    /**
     * Get the pager buttons flag
     * 
     * @return boolean
     */
    public function getPgbuttons()
    {
    	return $this->_pgbuttons;
    }
    
	/**
     * Show pager input if true
     * 
     * @param boolean $pginput
     * @return My_Datagrid
     */
    public function setPginput($pginput = true)
    {
    	$this->_pginput = (bool)$pginput;
    	return $this;
    }
    
    /**
     * Get the pager input flag
     * 
     * @return boolean
     */
    public function getPginput()
    {
    	return $this->_pginput;
    }
    
	/**
     * Show navigator if true
     * 
     * @param boolean $showNavigator
     * @return My_Datagrid
     */
    public function setShowNavigator($showNavigator = true)
    {
    	$this->_showNavigator = (bool)$showNavigator;
    	return $this;
    }
    
    /**
     * Get the showNavigator flag
     * 
     * @return boolean
     */
    public function getShowNavigator()
    {
    	return $this->_showNavigator;
    }
    
	/**
     * Set navigator options
     * 
     * @param boolean $navigatorOptions
     * @return My_Datagrid
     */
    public function setNavigatorOptions($navigatorOptions = '')
    {
    	$this->_navigatorOptions = (string)$navigatorOptions;
    	return $this;
    }
    
    /**
     * Get navigator options
     * 
     * @return string
     */
    public function getNavigatorOptions()
    {
    	return $this->_navigatorOptions;
    }
    
	/**
     * Set navigator edit options
     * 
     * @param boolean $navigatorEditOptions
     * @return My_Datagrid
     */
    public function setNavigatorEditOptions($navigatorEditOptions = '')
    {
    	$this->_navigatorEditOptions = (string)$navigatorEditOptions;
    	return $this;
    }
    
    /**
     * Get navigator edit options
     * 
     * @return string
     */
    public function getNavigatorEditOptions()
    {
    	return $this->_navigatorEditOptions;
    }
    
	/**
     * Set navigator add options
     * 
     * @param boolean $navigatorAddOptions
     * @return My_Datagrid
     */
    public function setNavigatorAddOptions($navigatorAddOptions = '')
    {
    	$this->_navigatorAddOptions = (string)$navigatorAddOptions;
    	return $this;
    }
    
    /**
     * Get navigator add options
     * 
     * @return string
     */
    public function getNavigatorAddOptions()
    {
    	return $this->_navigatorAddOptions;
    }
    
	/**
     * Set navigator delete options
     * 
     * @param boolean $navigatorDeleteOptions
     * @return My_Datagrid
     */
    public function setNavigatorDeleteOptions($navigatorDeleteOptions = '')
    {
    	$this->_navigatorDeleteOptions = (string)$navigatorDeleteOptions;
    	return $this;
    }
    
    /**
     * Get navigator delete options
     * 
     * @return string
     */
    public function getNavigatorDeleteOptions()
    {
    	return $this->_navigatorDeleteOptions;
    }
    
	/**
     * Set navigator search options
     * 
     * @param boolean $navigatorSearchOptions
     * @return My_Datagrid
     */
    public function setNavigatorSearchOptions($navigatorSearchOptions = '')
    {
    	$this->_navigatorSearchOptions = (string)$navigatorSearchOptions;
    	return $this;
    }
    
    /**
     * Get navigator search options
     * 
     * @return string
     */
    public function getNavigatorSearchOptions()
    {
    	return $this->_navigatorSearchOptions;
    }
    
	/**
     * Set navigator view options
     * 
     * @param boolean $navigatorViewOptions
     * @return My_Datagrid
     */
    public function setNavigatorViewOptions($navigatorViewOptions = '')
    {
    	$this->_navigatorViewOptions = (string)$navigatorViewOptions;
    	return $this;
    }
    
    /**
     * Get navigator view options
     * 
     * @return string
     */
    public function getNavigatorViewOptions()
    {
    	return $this->_navigatorViewOptions;
    }
    
	/**
     * Set navigator custom buttons
     * 
     * @param array $navigatorCustomButtons
     * @return My_Datagrid
     */
    public function setNavigatorCustomButtons(array $navigatorCustomButtons = array())
    {
    	$this->_navigatorCustomButtons = $navigatorCustomButtons;
    	return $this;
    }
    
    /**
     * Get navigator custom buttons
     * 
     * @return array
     */
    public function getNavigatorCustomButtons()
    {
    	return $this->_navigatorCustomButtons;
    }
    
	/**
     * Enable subGrid if true
     * 
     * @param boolean $subGrid
     * @return My_Datagrid
     */
    public function setSubGrid($subGrid = true)
    {
    	$this->_subGrid = (bool)$subGrid;
    	return $this;
    }
    
    /**
     * Get the subGrid flag
     * 
     * @return boolean
     */
    public function getSubGrid()
    {
    	return $this->_subGrid;
    }
    
	/**
     * Set subGridUrl
     * 
     * @param string $subGridUrl
     * @return My_Datagrid
     */
    public function setSubGridUrl($subGridUrl = '')
    {
    	$this->_subGridUrl = (string)$subGridUrl;
    	return $this;
    }
    
    /**
     * Get subGridUrl
     * 
     * @return string
     */
    public function getSubGridUrl()
    {
    	return $this->_subGridUrl;
    }
    
	/**
     * Set subGridRowExpanded
     * 
     * @param string $subGridRowExpanded
     * @return My_Datagrid
     */
    public function setSubGridRowExpanded($subGridRowExpanded = '')
    {
    	$this->_subGridRowExpanded = (string)$subGridRowExpanded;
    	return $this;
    }
    
    /**
     * Get subGridRowExpanded
     * 
     * @return string
     */
    public function getSubGridRowExpanded()
    {
    	return $this->_subGridRowExpanded;
    }
    
	/**
     * Set subGridRowColapsed
     * 
     * @param string $subGridRowColapsed
     * @return My_Datagrid
     */
    public function setSubGridRowColapsed($subGridRowColapsed = '')
    {
    	$this->_subGridRowColapsed = (string)$subGridRowColapsed;
    	return $this;
    }
    
    /**
     * Get subGridRowColapsed
     * 
     * @return string
     */
    public function getSubGridRowColapsed()
    {
    	return $this->_subGridRowColapsed;
    }
    
	/**
     * Set gridComplete function contents
     * 
     * @param string $gridComplete
     * @return My_Datagrid
     */
    public function setGridComplete($gridComplete = '')
    {
    	$this->_gridComplete = (string)$gridComplete;
    	return $this;
    }
    
    /**
     * Get gridComplete function contents
     * 
     * @return string
     */
    public function getGridComplete()
    {
    	return $this->_gridComplete;
    }
    
	/**
     * Set loadBeforeSend function contents
     * 
     * @param string $loadBeforeSend
     * @return My_Datagrid
     */
    public function setLoadBeforeSend($loadBeforeSend = '')
    {
    	$this->_loadBeforeSend = (string)$loadBeforeSend;
    	return $this;
    }
    
    /**
     * Get loadBeforeSend function contents
     * 
     * @return string
     */
    public function getLoadBeforeSend()
    {
    	return $this->_loadBeforeSend;
    }
    
	/**
     * Set loadComplete function contents
     * 
     * @param string $loadComplete
     * @return My_Datagrid
     */
    public function setLoadComplete($loadComplete = '')
    {
    	$this->_loadComplete = (string)$loadComplete;
    	return $this;
    }
    
    /**
     * Get loadComplete function contents
     * 
     * @return string
     */
    public function getLoadComplete()
    {
    	return $this->_loadComplete;
    }
    
	/**
     * Set loadError function contents
     * 
     * @param string $loadError
     * @return My_Datagrid
     */
    public function setLoadError($loadError = '')
    {
    	$this->_loadError = (string)$loadError;
    	return $this;
    }
    
    /**
     * Get loadError function contents
     * 
     * @return string
     */
    public function getLoadError()
    {
    	return $this->_loadError;
    }
    
	/**
     * Set onDblClickRow function contents
     * 
     * @param string $onDblClickRow
     * @return My_Datagrid
     */
    public function setOnDblClickRow($onDblClickRow = '')
    {
    	$this->_onDblClickRow = (string)$onDblClickRow;
    	return $this;
    }
    
    /**
     * Get onDblClickRow function contents
     * 
     * @return string
     */
    public function getOnDblClickRow()
    {
    	return $this->_onDblClickRow;
    }
    
	/**
     * Set onSelectRow function contents
     * 
     * @param string $onSelectRow
     * @return My_Datagrid
     */
    public function setOnSelectRow($onSelectRow = '')
    {
    	$this->_onSelectRow = (string)$onSelectRow;
    	return $this;
    }
    
    /**
     * Get onSelectRow function contents
     * 
     * @return string
     */
    public function getOnSelectRow()
    {
    	return $this->_onSelectRow;
    }
    
	/**
     * Set serializeGridData function contents
     * 
     * @param string $serializeGridData
     * @return My_Datagrid
     */
    public function setSerializeGridData($serializeGridData = '')
    {
    	$this->_serializeGridData = (string)$serializeGridData;
    	return $this;
    }
    
    /**
     * Get serializeGridData function contents
     * 
     * @return string
     */
    public function getSerializeGridData()
    {
    	return $this->_serializeGridData;
    }
    
    /**
     * Set treeGrid
     * 
     * @param boolean $treeGrid
     * @return My_Datagrid
     */
    public function setTreeGrid($treeGrid = false)
    {
    	$this->_treeGrid = (bool)$treeGrid;
    	return $this;
    }
    
    /**
     * Get treeGrid
     * 
     * @return boolean
     */
    public function getTreeGrid()
    {
    	return $this->_treeGrid;
    }
    
	/**
     * Set treeGridModel
     * 
     * @param string $treeGridModel
     * @return My_Datagrid
     */
    public function setTreeGridModel($treeGridModel = 'nested')
    {
    	$this->_treeGridModel = (string)$treeGridModel;
    	return $this;
    }
    
    /**
     * Get treeIcons
     * 
     * @return array
     */
    public function getTreeIcons()
    {
    	return $this->_treeIcons;
    }
    
    /**
     * Set treeIcons
     * 
     * @param string $treeIcons
     * @return My_Datagrid
     */
    public function setTreeIcons(array $treeIcons = 
    	array(
	    	'plus'=>'ui-icon-triangle-1-e',
	    	'minus'=>'ui-icon-triangle-1-s',
	    	'leaf'=>'ui-icon-radio-off',
    	)
    )
    {
    	$this->_treeIcons = $treeIcons;
    	return $this;
    }
    
    /**
     * Get treeGrid
     * 
     * @return boolean
     */
    public function getTreeGridModel()
    {
    	return $this->_treeGridModel;
    }
    
	/**
     * Set expandColumn
     * 
     * @param string $expandColumn
     * @return My_Datagrid
     */
    public function setExpandColumn($expandColumn = '')
    {
    	$this->_expandColumn = (string)$expandColumn;
    	return $this;
    }
    
    /**
     * Get expandColumn
     * 
     * @return string
     */
    public function getExpandColumn()
    {
    	return $this->_expandColumn;
    }
    
	/**
     * Set expandColClick
     * 
     * @param bool $expandColClick
     * @return My_Datagrid
     */
    public function setExpandColClick($expandColClick = true)
    {
    	$this->_expandColClick = (bool)$expandColClick;
    	return $this;
    }
    
    /**
     * Get expandColClick
     * 
     * @return bool
     */
    public function getExpandColClick()
    {
    	return $this->_expandColClick;
    }
    
	/**
     * Set cellEdit
     * 
     * @param boolean $cellEdit
     * @return My_Datagrid
     */
    public function setCellEdit($cellEdit = false)
    {
    	$this->_cellEdit = (bool)$cellEdit;
    	return $this;
    }
    
    /**
     * Get cellEdit
     * 
     * @return boolean
     */
    public function getCellEdit()
    {
    	return $this->_cellEdit;
    }
    
	/**
     * Set cellSubmit
     * 
     * @param string $cellSubmit
     * @return My_Datagrid
     */
    public function setCellSubmit($cellSubmit = 'remote')
    {
    	$this->_cellSubmit = (string)$cellSubmit;
    	return $this;
    }
    
    /**
     * Get cellSubmit
     * 
     * @return string
     */
    public function getCellSubmit()
    {
    	return $this->_cellSubmit;
    }
    
	/**
     * Set cellUrl
     * 
     * @param string $cellUrl
     * @return My_Datagrid
     */
    public function setCellUrl($cellUrl = '')
    {
    	$this->_cellUrl = (string)$cellUrl;
    	return $this;
    }
    
    /**
     * Get cellUrl
     * 
     * @return string
     */
    public function getCellUrl()
    {
    	return $this->_cellUrl;
    }
    
    /**
     * Set userData
     * 
     * @param array $userData
     * $return My_Datagrid
     */
    public function setUserData(array $userData)
    {
        $this->_userData = $userData;
        return $this;
    }
    
    /**
     * Get userData
     * 
     * @return array
     */
    public function getUserData()
    {
        return $this->_userData;
    }
    
	/**
     * Renders the datagrid.
     * 
     * @param  Zend_View_Interface $view 
     * @return string
     */
    public function render(Zend_View_Interface $view = null)
    {
        if (null !== $view) {
            $this->setView($view);
        }
        $view = $this->getView();
        $viewHelper = $this->_viewHelper;
        return $view->$viewHelper($this);
    }
}
