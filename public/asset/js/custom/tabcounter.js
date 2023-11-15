function tabCounter(errorContainer , counterContainer){

      localStorage.pageTab ? extraPage() : currentPage() ;

      function extraPage(){
        var count = 1;
        var numberOfTabs = parseInt(localStorage.getItem("numberOfTabs"));
        localStorage.setItem("numberOfTabs", count + (numberOfTabs ? numberOfTabs : 0));
        setInterval(() => {
          var newnumberOfTabs = parseInt(localStorage.getItem("numberOfTabs"));
          $(counterContainer).text(newnumberOfTabs);
          $(window).on('unload' ,()=>{
              localStorage.setItem("numberOfTabs", (newnumberOfTabs) - 1);
          });
        }, 1000);
         $(errorContainer).show();
      }
      function currentPage(){
        localStorage.pageTab = "1";
        $(window).on('beforeunload' ,()=> {
          localStorage.pageTab = "";
        });
      }
}
