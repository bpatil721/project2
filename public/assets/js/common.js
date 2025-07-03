window.submitAjax = async function(url,data,method='POST'){
    let res = await $.ajax({
        url:url,
        data:data,
        method:method,
        processData:false,
        contentType:false,
    })
    return res;
}
$('#logout').on('click',async function(){
    let logoutUrl  = url + `/logout`;
    let data = new FormData();
    data.append('_token',$('meta[name="csrf-token"]').attr('content'));
   let res = await submitAjax(logoutUrl ,data)
   console.log(res.status);
   if(res.status){
        toastr.success(res.msg);
        window.location.href=url; 
   }else{
        toastr.error(res.msg);
   }
})