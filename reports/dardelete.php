<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "darinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$dar_delete = NULL; // Initialize page object first

class cdar_delete extends cdar {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{3FC7CB86-1F85-46A6-9781-36E2788B8DB5}';

	// Table name
	var $TableName = 'dar';

	// Page object name
	var $PageObjName = 'dar_delete';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (dar)
		if (!isset($GLOBALS["dar"]) || get_class($GLOBALS["dar"]) == "cdar") {
			$GLOBALS["dar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["dar"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'dar', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("darlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->_userid->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->_userid->Visible = FALSE;
		$this->date->SetVisibility();
		$this->client->SetVisibility();
		$this->person->SetVisibility();
		$this->desig->SetVisibility();
		$this->phone->SetVisibility();
		$this->_email->SetVisibility();
		$this->activity->SetVisibility();
		$this->req->SetVisibility();
		$this->followup->SetVisibility();
		$this->remark->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $dar;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($dar);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		// Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("darlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in dar class, darinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("darlist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->_userid->setDbValue($row['userid']);
		$this->date->setDbValue($row['date']);
		$this->client->setDbValue($row['client']);
		$this->person->setDbValue($row['person']);
		$this->desig->setDbValue($row['desig']);
		$this->phone->setDbValue($row['phone']);
		$this->_email->setDbValue($row['email']);
		$this->activity->setDbValue($row['activity']);
		$this->req->setDbValue($row['req']);
		$this->followup->setDbValue($row['followup']);
		$this->remark->setDbValue($row['remark']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['userid'] = NULL;
		$row['date'] = NULL;
		$row['client'] = NULL;
		$row['person'] = NULL;
		$row['desig'] = NULL;
		$row['phone'] = NULL;
		$row['email'] = NULL;
		$row['activity'] = NULL;
		$row['req'] = NULL;
		$row['followup'] = NULL;
		$row['remark'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->_userid->DbValue = $row['userid'];
		$this->date->DbValue = $row['date'];
		$this->client->DbValue = $row['client'];
		$this->person->DbValue = $row['person'];
		$this->desig->DbValue = $row['desig'];
		$this->phone->DbValue = $row['phone'];
		$this->_email->DbValue = $row['email'];
		$this->activity->DbValue = $row['activity'];
		$this->req->DbValue = $row['req'];
		$this->followup->DbValue = $row['followup'];
		$this->remark->DbValue = $row['remark'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->phone->FormValue == $this->phone->CurrentValue && is_numeric(ew_StrToFloat($this->phone->CurrentValue)))
			$this->phone->CurrentValue = ew_StrToFloat($this->phone->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// userid
		// date
		// client
		// person
		// desig
		// phone
		// email
		// activity
		// req
		// followup
		// remark

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// userid
		$this->_userid->ViewValue = $this->_userid->CurrentValue;
		$this->_userid->ViewCustomAttributes = "";

		// date
		$this->date->ViewValue = $this->date->CurrentValue;
		$this->date->ViewValue = ew_FormatDateTime($this->date->ViewValue, 0);
		$this->date->ViewCustomAttributes = "";

		// client
		$this->client->ViewValue = $this->client->CurrentValue;
		$this->client->ViewCustomAttributes = "";

		// person
		$this->person->ViewValue = $this->person->CurrentValue;
		$this->person->ViewCustomAttributes = "";

		// desig
		$this->desig->ViewValue = $this->desig->CurrentValue;
		$this->desig->ViewCustomAttributes = "";

		// phone
		$this->phone->ViewValue = $this->phone->CurrentValue;
		$this->phone->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// activity
		$this->activity->ViewValue = $this->activity->CurrentValue;
		$this->activity->ViewCustomAttributes = "";

		// req
		$this->req->ViewValue = $this->req->CurrentValue;
		$this->req->ViewCustomAttributes = "";

		// followup
		$this->followup->ViewValue = $this->followup->CurrentValue;
		$this->followup->ViewCustomAttributes = "";

		// remark
		$this->remark->ViewValue = $this->remark->CurrentValue;
		$this->remark->ViewCustomAttributes = "";

			// userid
			$this->_userid->LinkCustomAttributes = "";
			$this->_userid->HrefValue = "";
			$this->_userid->TooltipValue = "";

			// date
			$this->date->LinkCustomAttributes = "";
			$this->date->HrefValue = "";
			$this->date->TooltipValue = "";

			// client
			$this->client->LinkCustomAttributes = "";
			$this->client->HrefValue = "";
			$this->client->TooltipValue = "";

			// person
			$this->person->LinkCustomAttributes = "";
			$this->person->HrefValue = "";
			$this->person->TooltipValue = "";

			// desig
			$this->desig->LinkCustomAttributes = "";
			$this->desig->HrefValue = "";
			$this->desig->TooltipValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";
			$this->phone->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// activity
			$this->activity->LinkCustomAttributes = "";
			$this->activity->HrefValue = "";
			$this->activity->TooltipValue = "";

			// req
			$this->req->LinkCustomAttributes = "";
			$this->req->HrefValue = "";
			$this->req->TooltipValue = "";

			// followup
			$this->followup->LinkCustomAttributes = "";
			$this->followup->HrefValue = "";
			$this->followup->TooltipValue = "";

			// remark
			$this->remark->LinkCustomAttributes = "";
			$this->remark->HrefValue = "";
			$this->remark->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['userid'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("darlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($dar_delete)) $dar_delete = new cdar_delete();

// Page init
$dar_delete->Page_Init();

// Page main
$dar_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$dar_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fdardelete = new ew_Form("fdardelete", "delete");

// Form_CustomValidate event
fdardelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fdardelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $dar_delete->ShowPageHeader(); ?>
<?php
$dar_delete->ShowMessage();
?>
<form name="fdardelete" id="fdardelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($dar_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $dar_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="dar">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($dar_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($dar->_userid->Visible) { // userid ?>
		<th class="<?php echo $dar->_userid->HeaderCellClass() ?>"><span id="elh_dar__userid" class="dar__userid"><?php echo $dar->_userid->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dar->date->Visible) { // date ?>
		<th class="<?php echo $dar->date->HeaderCellClass() ?>"><span id="elh_dar_date" class="dar_date"><?php echo $dar->date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dar->client->Visible) { // client ?>
		<th class="<?php echo $dar->client->HeaderCellClass() ?>"><span id="elh_dar_client" class="dar_client"><?php echo $dar->client->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dar->person->Visible) { // person ?>
		<th class="<?php echo $dar->person->HeaderCellClass() ?>"><span id="elh_dar_person" class="dar_person"><?php echo $dar->person->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dar->desig->Visible) { // desig ?>
		<th class="<?php echo $dar->desig->HeaderCellClass() ?>"><span id="elh_dar_desig" class="dar_desig"><?php echo $dar->desig->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dar->phone->Visible) { // phone ?>
		<th class="<?php echo $dar->phone->HeaderCellClass() ?>"><span id="elh_dar_phone" class="dar_phone"><?php echo $dar->phone->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dar->_email->Visible) { // email ?>
		<th class="<?php echo $dar->_email->HeaderCellClass() ?>"><span id="elh_dar__email" class="dar__email"><?php echo $dar->_email->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dar->activity->Visible) { // activity ?>
		<th class="<?php echo $dar->activity->HeaderCellClass() ?>"><span id="elh_dar_activity" class="dar_activity"><?php echo $dar->activity->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dar->req->Visible) { // req ?>
		<th class="<?php echo $dar->req->HeaderCellClass() ?>"><span id="elh_dar_req" class="dar_req"><?php echo $dar->req->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dar->followup->Visible) { // followup ?>
		<th class="<?php echo $dar->followup->HeaderCellClass() ?>"><span id="elh_dar_followup" class="dar_followup"><?php echo $dar->followup->FldCaption() ?></span></th>
<?php } ?>
<?php if ($dar->remark->Visible) { // remark ?>
		<th class="<?php echo $dar->remark->HeaderCellClass() ?>"><span id="elh_dar_remark" class="dar_remark"><?php echo $dar->remark->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$dar_delete->RecCnt = 0;
$i = 0;
while (!$dar_delete->Recordset->EOF) {
	$dar_delete->RecCnt++;
	$dar_delete->RowCnt++;

	// Set row properties
	$dar->ResetAttrs();
	$dar->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$dar_delete->LoadRowValues($dar_delete->Recordset);

	// Render row
	$dar_delete->RenderRow();
?>
	<tr<?php echo $dar->RowAttributes() ?>>
<?php if ($dar->_userid->Visible) { // userid ?>
		<td<?php echo $dar->_userid->CellAttributes() ?>>
<span id="el<?php echo $dar_delete->RowCnt ?>_dar__userid" class="dar__userid">
<span<?php echo $dar->_userid->ViewAttributes() ?>>
<?php echo $dar->_userid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dar->date->Visible) { // date ?>
		<td<?php echo $dar->date->CellAttributes() ?>>
<span id="el<?php echo $dar_delete->RowCnt ?>_dar_date" class="dar_date">
<span<?php echo $dar->date->ViewAttributes() ?>>
<?php echo $dar->date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dar->client->Visible) { // client ?>
		<td<?php echo $dar->client->CellAttributes() ?>>
<span id="el<?php echo $dar_delete->RowCnt ?>_dar_client" class="dar_client">
<span<?php echo $dar->client->ViewAttributes() ?>>
<?php echo $dar->client->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dar->person->Visible) { // person ?>
		<td<?php echo $dar->person->CellAttributes() ?>>
<span id="el<?php echo $dar_delete->RowCnt ?>_dar_person" class="dar_person">
<span<?php echo $dar->person->ViewAttributes() ?>>
<?php echo $dar->person->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dar->desig->Visible) { // desig ?>
		<td<?php echo $dar->desig->CellAttributes() ?>>
<span id="el<?php echo $dar_delete->RowCnt ?>_dar_desig" class="dar_desig">
<span<?php echo $dar->desig->ViewAttributes() ?>>
<?php echo $dar->desig->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dar->phone->Visible) { // phone ?>
		<td<?php echo $dar->phone->CellAttributes() ?>>
<span id="el<?php echo $dar_delete->RowCnt ?>_dar_phone" class="dar_phone">
<span<?php echo $dar->phone->ViewAttributes() ?>>
<?php echo $dar->phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dar->_email->Visible) { // email ?>
		<td<?php echo $dar->_email->CellAttributes() ?>>
<span id="el<?php echo $dar_delete->RowCnt ?>_dar__email" class="dar__email">
<span<?php echo $dar->_email->ViewAttributes() ?>>
<?php echo $dar->_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dar->activity->Visible) { // activity ?>
		<td<?php echo $dar->activity->CellAttributes() ?>>
<span id="el<?php echo $dar_delete->RowCnt ?>_dar_activity" class="dar_activity">
<span<?php echo $dar->activity->ViewAttributes() ?>>
<?php echo $dar->activity->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dar->req->Visible) { // req ?>
		<td<?php echo $dar->req->CellAttributes() ?>>
<span id="el<?php echo $dar_delete->RowCnt ?>_dar_req" class="dar_req">
<span<?php echo $dar->req->ViewAttributes() ?>>
<?php echo $dar->req->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dar->followup->Visible) { // followup ?>
		<td<?php echo $dar->followup->CellAttributes() ?>>
<span id="el<?php echo $dar_delete->RowCnt ?>_dar_followup" class="dar_followup">
<span<?php echo $dar->followup->ViewAttributes() ?>>
<?php echo $dar->followup->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($dar->remark->Visible) { // remark ?>
		<td<?php echo $dar->remark->CellAttributes() ?>>
<span id="el<?php echo $dar_delete->RowCnt ?>_dar_remark" class="dar_remark">
<span<?php echo $dar->remark->ViewAttributes() ?>>
<?php echo $dar->remark->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$dar_delete->Recordset->MoveNext();
}
$dar_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $dar_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fdardelete.Init();
</script>
<?php
$dar_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$dar_delete->Page_Terminate();
?>
