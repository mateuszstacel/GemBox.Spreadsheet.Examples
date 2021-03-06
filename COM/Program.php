// Create ComHelper object and set license.
// NOTE: If you're using a Professional version you'll need to put your serial key below.
$comHelper = new Com("GemBox.Spreadsheet.ComHelper", null, CP_UTF8);
$comHelper->ComSetLicense("FREE-LIMITED-KEY");

// Create new ExcelFile object and add new worksheet.
$workbook = new Com("GemBox.Spreadsheet.ExcelFile", null, CP_UTF8);
$worksheet = $workbook->Worksheets->Add("Sheet1");

// Format first row columns.
$header = $worksheet->Cells->GetSubrange("A1", "B1");
$header->Merged = true;
$header->Value = "GemBox.Spreadsheet COM Example";
$header->Style->HorizontalAlignment = 2;
$header->Style->Font->Weight = 700;

// Set column A width and values.
$column = $comHelper->GetColumn($worksheet, 0);
$column->Width = 20 * 256;
$column->Cells->Item(1)->Value = "1 + 1 =";
$column->Cells->Item(2)->Value = "B2 * 2 =";
$column->Cells->Item(3)->Value = "B3 * 120% =";
$column->Cells->Item(4)->Value = "SUM(B2:B4) =";

// Set column B width and formulas.
$column = $comHelper->GetColumn($worksheet, 1);
$column->Width = 20 * 256;
$column->Cells->Item(1)->Formula = "=1 + 1";
$column->Cells->Item(2)->Formula = "=B2 * 2";
$column->Cells->Item(3)->Formula = "=B3 * 120%";
$column->Cells->Item(4)->Formula = "=SUM(B2:B4)";

// Calculate all worksheet formulas.
$worksheet->Calculate();

// Output formula results.
echo "Cell calculation results:";
for ($i = 1; $i < 5; $i++)
{
    echo " B" . $i . " = " . $column->Cells->Item($i)->Value;
}

// Get output path and save workbook as XLSX file.
$path = getcwd() . "\\ComExample.xlsx";

$workbook->Save($path);
echo "Workbook saved as '" . $path . "'";