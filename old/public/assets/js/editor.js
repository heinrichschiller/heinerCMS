tinymce.init({
    selector: '#texteditor',
    height: 400,
    plugins: [
        'advlist autolink lists link image charmap code print preview anchor textcolor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste codesample help wordcount'
    ],
    codesample_languages: [
		{text: 'HTML/XML', value: 'markup'},
		{text: 'JavaScript', value: 'javascript'},
		{text: 'CSS', value: 'css'},
		{text: 'PHP', value: 'php'},
		{text: 'Delphi', value: 'delphi'},
		{text: 'Python', value: 'python'},
		{text: 'Java', value: 'java'},
		{text: 'C', value: 'c'},
		{text: 'C#', value: 'csharp'},
		{text: 'C++', value: 'cpp'}
	],
    toolbar: ['undo redo | formatselect | bold italic backcolor |',
    ' alignleft aligncenter alignright alignjustify |',
    ' bullist numlist outdent indent | removeformat | codesample code'
    ]
});
