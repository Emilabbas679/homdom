
// FilePond.registerPlugin(
//     FilePondPluginFileValidateSize,
//     FilePondPluginImageExifOrientation,
//     FilePondPluginImageCrop,
//     FilePondPluginImageResize,
//     FilePondPluginImagePreview,
//     FilePondPluginImageTransform,
//     FilePondPluginFileValidateSize,
//     FilePondPluginMediaPreview,
//     FilePondPluginFileValidateType
// );

//
// FilePond.setOptions({
//     server: {
//         process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
//
//             const formData = new FormData();
//             formData.append(fieldName, file, file.name);
//             const request = new XMLHttpRequest();
//             //console.log(request.responseText);
//             request.open('POST', '/include/tools/filepond/filepond.php');
//             request.upload.onprogress = (e) => {
//                 progress(e.lengthComputable, e.loaded, e.total);
//             };
//             request.onload = function () {
//                 if (request.status >= 200 && request.status < 300) {
//                     console.log(request.responseText)
//                     load(request.responseText);
//                 } else {
//                     error('oh no');
//                 }
//             };
//
//             request.send(formData);
//         },
//         revert: '/static/api/api/delete',
//         restore: '/static/api/restore?id=',
//         fetch: '/static/api/fetch?data=',
//         load: '/static/api/load',
//     },
//     acceptedFileTypes: [
//         'image/*',
//         'video/*'
//     ],
// });

//var pond = FilePond.create(document.querySelector('input.video'));
//var pond = FilePond.create(document.querySelector('input.video_image'));



