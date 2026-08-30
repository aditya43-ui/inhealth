/**
*	@category	javascript, untuk menampung semua multi select dropdown
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/

/**
 * - digunakan untuk mengenerate dropdown multiselect sesuai attibute idnya
 * @param {type} att
 * @returns {enerate dropdown multiselect}
 */
function dropMulti(att){
    var id = jQuery("#"+att);
    
    jQuery(id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
    }).hide();	
}




/**
 * - digunakan untuk mengenerate dropdown multiselect sesuai attibute idnya dan memfilter dropdown multiselect relasinya yang dituju
 * @param {type} att
 * @param {type} att_tujuan
 * @returns {enerate dropdown multiselect}
 */
function dropMultiRelate(att,att_tujuan){
   
}
