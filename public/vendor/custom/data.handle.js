function handle(input) {
    const data = input.formality;
    const headers = Object.keys(data[0]).toString();

    const main = data.map((item) => {
        return Object.values(item).toString();
    });

    return [headers, ...main].join('\n');
}

function csvDownload(input, title) {
    const blob = new Blob([input], { type: 'application/csv' });

    const url = URL.createObjectURL(blob);

    const a = document.createElement('a');
    a.download = `${title}.csv`;
    a.href = url;
    a.style.display = 'none';

    document.body.appendChild(a);

    a.click();
    a.remove();
    URL.revokeObjectURL(url);

}

/*
const EXCEL_TYPE = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8';
const EXCEL_EXTENSION = '.xlsx';

function excelHandle(input){
    const worksheet = XLSX.utils.json_to_sheet(input);
    const workbook = {
        Sheets: {
            'data' : worksheet
        },
        SheetNames: ['data']
    };
    console.log(XLSX.write(workbook, {bookType: 'xlsx', type: 'array'}));
    return XLSX.write(workbook, {bookType: 'xlsx', type: 'array'});
    // xlsxDownload(excelBuffer, 'data_template');
}

function xlsxDownload(buffer, filename){
    const data = new Blob([buffer], {type: EXCEL_TYPE});
    
    const url = URL.createObjectURL(data);

    const a = document.createElement('a');
    a.download = `${filename}.${EXCEL_EXTENSION}`;
    a.href = url;
    a.style.display = 'none';

    document.body.appendChild(a);

    a.click();
    a.remove();
    URL.revokeObjectURL(url);
}
*/
