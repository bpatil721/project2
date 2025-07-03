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
$('#logout').on('click',function(){
    let logoutUrl  = url + `/logout`;
    let data = new FormData();
    data.append('_token',$('meta[name="csrf-token"]').attr('content'));
   let res = submitAjax(logoutUrl ,data)
   if(res.status){
        toastr.success(res.msg);
        window.location.href=`{{route('login')}}`; 
   }else{
        toastr.error(res.msg);
   }
})