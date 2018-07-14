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

$dar_add = NULL; // Initialize page object first

class cdar_add extends cdar {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{3FC7CB86-1F85-46A6-9781-36E2788B8DB5}';

	// Table name
	var $TableName = 'dar';

	// Page object name
	var $PageObjName = 'dar_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if (!$Security->CanAdd()) {
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
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "darview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["_userid"] != "") {
				$this->_userid->setQueryStringValue($_GET["_userid"]);
				$this->setKey("_userid", $this->_userid->CurrentValue); // Set up key
			} else {
				$this->setKey("_userid", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("darlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "darlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "darview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->_userid->CurrentValue = NULL;
		$this->_userid->OldValue = $this->_userid->CurrentValue;
		$this->date->CurrentValue = NULL;
		$this->date->OldValue = $this->date->CurrentValue;
		$this->client->CurrentValue = NULL;
		$this->client->OldValue = $this->client->CurrentValue;
		$this->person->CurrentValue = NULL;
		$this->person->OldValue = $this->person->CurrentValue;
		$this->desig->CurrentValue = NULL;
		$this->desig->OldValue = $this->desig->CurrentValue;
		$this->phone->CurrentValue = NULL;
		$this->phone->OldValue = $this->phone->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->activity->CurrentValue = NULL;
		$this->activity->OldValue = $this->activity->CurrentValue;
		$this->req->CurrentValue = NULL;
		$this->req->OldValue = $this->req->CurrentValue;
		$this->followup->CurrentValue = NULL;
		$this->followup->OldValue = $this->followup->CurrentValue;
		$this->remark->CurrentValue = NULL;
		$this->remark->OldValue = $this->remark->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->date->FldIsDetailKey) {
			$this->date->setFormValue($objForm->GetValue("x_date"));
			$this->date->CurrentValue = ew_UnFormatDateTime($this->date->CurrentValue, 0);
		}
		if (!$this->client->FldIsDetailKey) {
			$this->client->setFormValue($objForm->GetValue("x_client"));
		}
		if (!$this->person->FldIsDetailKey) {
			$this->person->setFormValue($objForm->GetValue("x_person"));
		}
		if (!$this->desig->FldIsDetailKey) {
			$this->desig->setFormValue($objForm->GetValue("x_desig"));
		}
		if (!$this->phone->FldIsDetailKey) {
			$this->phone->setFormValue($objForm->GetValue("x_phone"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->activity->FldIsDetailKey) {
			$this->activity->setFormValue($objForm->GetValue("x_activity"));
		}
		if (!$this->req->FldIsDetailKey) {
			$this->req->setFormValue($objForm->GetValue("x_req"));
		}
		if (!$this->followup->FldIsDetailKey) {
			$this->followup->setFormValue($objForm->GetValue("x_followup"));
		}
		if (!$this->remark->FldIsDetailKey) {
			$this->remark->setFormValue($objForm->GetValue("x_remark"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->date->CurrentValue = $this->date->FormValue;
		$this->date->CurrentValue = ew_UnFormatDateTime($this->date->CurrentValue, 0);
		$this->client->CurrentValue = $this->client->FormValue;
		$this->person->CurrentValue = $this->person->FormValue;
		$this->desig->CurrentValue = $this->desig->FormValue;
		$this->phone->CurrentValue = $this->phone->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->activity->CurrentValue = $this->activity->FormValue;
		$this->req->CurrentValue = $this->req->FormValue;
		$this->followup->CurrentValue = $this->followup->FormValue;
		$this->remark->CurrentValue = $this->remark->FormValue;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['userid'] = $this->_userid->CurrentValue;
		$row['date'] = $this->date->CurrentValue;
		$row['client'] = $this->client->CurrentValue;
		$row['person'] = $this->person->CurrentValue;
		$row['desig'] = $this->desig->CurrentValue;
		$row['phone'] = $this->phone->CurrentValue;
		$row['email'] = $this->_email->CurrentValue;
		$row['activity'] = $this->activity->CurrentValue;
		$row['req'] = $this->req->CurrentValue;
		$row['followup'] = $this->followup->CurrentValue;
		$row['remark'] = $this->remark->CurrentValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("_userid")) <> "")
			$this->_userid->CurrentValue = $this->getKey("_userid"); // userid
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// date
			$this->date->EditAttrs["class"] = "form-control";
			$this->date->EditCustomAttributes = "";
			$this->date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->date->CurrentValue, 8));
			$this->date->PlaceHolder = ew_RemoveHtml($this->date->FldCaption());

			// client
			$this->client->EditAttrs["class"] = "form-control";
			$this->client->EditCustomAttributes = "";
			$this->client->EditValue = ew_HtmlEncode($this->client->CurrentValue);
			$this->client->PlaceHolder = ew_RemoveHtml($this->client->FldCaption());

			// person
			$this->person->EditAttrs["class"] = "form-control";
			$this->person->EditCustomAttributes = "";
			$this->person->EditValue = ew_HtmlEncode($this->person->CurrentValue);
			$this->person->PlaceHolder = ew_RemoveHtml($this->person->FldCaption());

			// desig
			$this->desig->EditAttrs["class"] = "form-control";
			$this->desig->EditCustomAttributes = "";
			$this->desig->EditValue = ew_HtmlEncode($this->desig->CurrentValue);
			$this->desig->PlaceHolder = ew_RemoveHtml($this->desig->FldCaption());

			// phone
			$this->phone->EditAttrs["class"] = "form-control";
			$this->phone->EditCustomAttributes = "";
			$this->phone->EditValue = ew_HtmlEncode($this->phone->CurrentValue);
			$this->phone->PlaceHolder = ew_RemoveHtml($this->phone->FldCaption());
			if (strval($this->phone->EditValue) <> "" && is_numeric($this->phone->EditValue)) $this->phone->EditValue = ew_FormatNumber($this->phone->EditValue, -2, -1, -2, 0);

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// activity
			$this->activity->EditAttrs["class"] = "form-control";
			$this->activity->EditCustomAttributes = "";
			$this->activity->EditValue = ew_HtmlEncode($this->activity->CurrentValue);
			$this->activity->PlaceHolder = ew_RemoveHtml($this->activity->FldCaption());

			// req
			$this->req->EditAttrs["class"] = "form-control";
			$this->req->EditCustomAttributes = "";
			$this->req->EditValue = ew_HtmlEncode($this->req->CurrentValue);
			$this->req->PlaceHolder = ew_RemoveHtml($this->req->FldCaption());

			// followup
			$this->followup->EditAttrs["class"] = "form-control";
			$this->followup->EditCustomAttributes = "";
			$this->followup->EditValue = ew_HtmlEncode($this->followup->CurrentValue);
			$this->followup->PlaceHolder = ew_RemoveHtml($this->followup->FldCaption());

			// remark
			$this->remark->EditAttrs["class"] = "form-control";
			$this->remark->EditCustomAttributes = "";
			$this->remark->EditValue = ew_HtmlEncode($this->remark->CurrentValue);
			$this->remark->PlaceHolder = ew_RemoveHtml($this->remark->FldCaption());

			// Add refer script
			// date

			$this->date->LinkCustomAttributes = "";
			$this->date->HrefValue = "";

			// client
			$this->client->LinkCustomAttributes = "";
			$this->client->HrefValue = "";

			// person
			$this->person->LinkCustomAttributes = "";
			$this->person->HrefValue = "";

			// desig
			$this->desig->LinkCustomAttributes = "";
			$this->desig->HrefValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

			// activity
			$this->activity->LinkCustomAttributes = "";
			$this->activity->HrefValue = "";

			// req
			$this->req->LinkCustomAttributes = "";
			$this->req->HrefValue = "";

			// followup
			$this->followup->LinkCustomAttributes = "";
			$this->followup->HrefValue = "";

			// remark
			$this->remark->LinkCustomAttributes = "";
			$this->remark->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckDateDef($this->date->FormValue)) {
			ew_AddMessage($gsFormError, $this->date->FldErrMsg());
		}
		if (!ew_CheckNumber($this->phone->FormValue)) {
			ew_AddMessage($gsFormError, $this->phone->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// date
		$this->date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->date->CurrentValue, 0), NULL, FALSE);

		// client
		$this->client->SetDbValueDef($rsnew, $this->client->CurrentValue, NULL, FALSE);

		// person
		$this->person->SetDbValueDef($rsnew, $this->person->CurrentValue, NULL, FALSE);

		// desig
		$this->desig->SetDbValueDef($rsnew, $this->desig->CurrentValue, NULL, FALSE);

		// phone
		$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, NULL, FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, FALSE);

		// activity
		$this->activity->SetDbValueDef($rsnew, $this->activity->CurrentValue, NULL, FALSE);

		// req
		$this->req->SetDbValueDef($rsnew, $this->req->CurrentValue, NULL, FALSE);

		// followup
		$this->followup->SetDbValueDef($rsnew, $this->followup->CurrentValue, NULL, FALSE);

		// remark
		$this->remark->SetDbValueDef($rsnew, $this->remark->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("darlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($dar_add)) $dar_add = new cdar_add();

// Page init
$dar_add->Page_Init();

// Page main
$dar_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$dar_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fdaradd = new ew_Form("fdaradd", "add");

// Validate form
fdaradd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dar->date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_phone");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($dar->phone->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fdaradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fdaradd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $dar_add->ShowPageHeader(); ?>
<?php
$dar_add->ShowMessage();
?>
<form name="fdaradd" id="fdaradd" class="<?php echo $dar_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($dar_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $dar_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="dar">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($dar_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($dar->date->Visible) { // date ?>
	<div id="r_date" class="form-group">
		<label id="elh_dar_date" for="x_date" class="<?php echo $dar_add->LeftColumnClass ?>"><?php echo $dar->date->FldCaption() ?></label>
		<div class="<?php echo $dar_add->RightColumnClass ?>"><div<?php echo $dar->date->CellAttributes() ?>>
<span id="el_dar_date">
<input type="text" data-table="dar" data-field="x_date" name="x_date" id="x_date" placeholder="<?php echo ew_HtmlEncode($dar->date->getPlaceHolder()) ?>" value="<?php echo $dar->date->EditValue ?>"<?php echo $dar->date->EditAttributes() ?>>
</span>
<?php echo $dar->date->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dar->client->Visible) { // client ?>
	<div id="r_client" class="form-group">
		<label id="elh_dar_client" for="x_client" class="<?php echo $dar_add->LeftColumnClass ?>"><?php echo $dar->client->FldCaption() ?></label>
		<div class="<?php echo $dar_add->RightColumnClass ?>"><div<?php echo $dar->client->CellAttributes() ?>>
<span id="el_dar_client">
<input type="text" data-table="dar" data-field="x_client" name="x_client" id="x_client" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($dar->client->getPlaceHolder()) ?>" value="<?php echo $dar->client->EditValue ?>"<?php echo $dar->client->EditAttributes() ?>>
</span>
<?php echo $dar->client->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dar->person->Visible) { // person ?>
	<div id="r_person" class="form-group">
		<label id="elh_dar_person" for="x_person" class="<?php echo $dar_add->LeftColumnClass ?>"><?php echo $dar->person->FldCaption() ?></label>
		<div class="<?php echo $dar_add->RightColumnClass ?>"><div<?php echo $dar->person->CellAttributes() ?>>
<span id="el_dar_person">
<input type="text" data-table="dar" data-field="x_person" name="x_person" id="x_person" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($dar->person->getPlaceHolder()) ?>" value="<?php echo $dar->person->EditValue ?>"<?php echo $dar->person->EditAttributes() ?>>
</span>
<?php echo $dar->person->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dar->desig->Visible) { // desig ?>
	<div id="r_desig" class="form-group">
		<label id="elh_dar_desig" for="x_desig" class="<?php echo $dar_add->LeftColumnClass ?>"><?php echo $dar->desig->FldCaption() ?></label>
		<div class="<?php echo $dar_add->RightColumnClass ?>"><div<?php echo $dar->desig->CellAttributes() ?>>
<span id="el_dar_desig">
<input type="text" data-table="dar" data-field="x_desig" name="x_desig" id="x_desig" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($dar->desig->getPlaceHolder()) ?>" value="<?php echo $dar->desig->EditValue ?>"<?php echo $dar->desig->EditAttributes() ?>>
</span>
<?php echo $dar->desig->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dar->phone->Visible) { // phone ?>
	<div id="r_phone" class="form-group">
		<label id="elh_dar_phone" for="x_phone" class="<?php echo $dar_add->LeftColumnClass ?>"><?php echo $dar->phone->FldCaption() ?></label>
		<div class="<?php echo $dar_add->RightColumnClass ?>"><div<?php echo $dar->phone->CellAttributes() ?>>
<span id="el_dar_phone">
<input type="text" data-table="dar" data-field="x_phone" name="x_phone" id="x_phone" size="30" placeholder="<?php echo ew_HtmlEncode($dar->phone->getPlaceHolder()) ?>" value="<?php echo $dar->phone->EditValue ?>"<?php echo $dar->phone->EditAttributes() ?>>
</span>
<?php echo $dar->phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dar->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_dar__email" for="x__email" class="<?php echo $dar_add->LeftColumnClass ?>"><?php echo $dar->_email->FldCaption() ?></label>
		<div class="<?php echo $dar_add->RightColumnClass ?>"><div<?php echo $dar->_email->CellAttributes() ?>>
<span id="el_dar__email">
<input type="text" data-table="dar" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($dar->_email->getPlaceHolder()) ?>" value="<?php echo $dar->_email->EditValue ?>"<?php echo $dar->_email->EditAttributes() ?>>
</span>
<?php echo $dar->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dar->activity->Visible) { // activity ?>
	<div id="r_activity" class="form-group">
		<label id="elh_dar_activity" for="x_activity" class="<?php echo $dar_add->LeftColumnClass ?>"><?php echo $dar->activity->FldCaption() ?></label>
		<div class="<?php echo $dar_add->RightColumnClass ?>"><div<?php echo $dar->activity->CellAttributes() ?>>
<span id="el_dar_activity">
<input type="text" data-table="dar" data-field="x_activity" name="x_activity" id="x_activity" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($dar->activity->getPlaceHolder()) ?>" value="<?php echo $dar->activity->EditValue ?>"<?php echo $dar->activity->EditAttributes() ?>>
</span>
<?php echo $dar->activity->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dar->req->Visible) { // req ?>
	<div id="r_req" class="form-group">
		<label id="elh_dar_req" for="x_req" class="<?php echo $dar_add->LeftColumnClass ?>"><?php echo $dar->req->FldCaption() ?></label>
		<div class="<?php echo $dar_add->RightColumnClass ?>"><div<?php echo $dar->req->CellAttributes() ?>>
<span id="el_dar_req">
<input type="text" data-table="dar" data-field="x_req" name="x_req" id="x_req" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($dar->req->getPlaceHolder()) ?>" value="<?php echo $dar->req->EditValue ?>"<?php echo $dar->req->EditAttributes() ?>>
</span>
<?php echo $dar->req->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dar->followup->Visible) { // followup ?>
	<div id="r_followup" class="form-group">
		<label id="elh_dar_followup" for="x_followup" class="<?php echo $dar_add->LeftColumnClass ?>"><?php echo $dar->followup->FldCaption() ?></label>
		<div class="<?php echo $dar_add->RightColumnClass ?>"><div<?php echo $dar->followup->CellAttributes() ?>>
<span id="el_dar_followup">
<input type="text" data-table="dar" data-field="x_followup" name="x_followup" id="x_followup" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($dar->followup->getPlaceHolder()) ?>" value="<?php echo $dar->followup->EditValue ?>"<?php echo $dar->followup->EditAttributes() ?>>
</span>
<?php echo $dar->followup->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($dar->remark->Visible) { // remark ?>
	<div id="r_remark" class="form-group">
		<label id="elh_dar_remark" for="x_remark" class="<?php echo $dar_add->LeftColumnClass ?>"><?php echo $dar->remark->FldCaption() ?></label>
		<div class="<?php echo $dar_add->RightColumnClass ?>"><div<?php echo $dar->remark->CellAttributes() ?>>
<span id="el_dar_remark">
<input type="text" data-table="dar" data-field="x_remark" name="x_remark" id="x_remark" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($dar->remark->getPlaceHolder()) ?>" value="<?php echo $dar->remark->EditValue ?>"<?php echo $dar->remark->EditAttributes() ?>>
</span>
<?php echo $dar->remark->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$dar_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $dar_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $dar_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fdaradd.Init();
</script>
<?php
$dar_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$dar_add->Page_Terminate();
?>
