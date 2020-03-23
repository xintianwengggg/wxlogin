// miniprogram/pages/index/index.js
Page({

  /**
   * 页面的初始数据
   */
  data: {

  },

  wxlogin(){
    wx.login({
      success: function (res) {
        var code = res.code;
        console.log(code);
        wx.getUserInfo({
          success: function (data) {
            let rawData = data.rawData;
            var signature = data.signature;
            var encryptedData = data.encryptedData;
            var iv = data.iv;
            console.log(data);
            wx.request({
              url: 'http://192.168.36.100/wxlogin/index.php',
              header: {
                'content-type': 'application/x-www-form-urlencoded'
              },
              data: {
                code,
                rawData: rawData,
                signature: signature,
                encryptedData: encryptedData,
                iv: iv,
              },
              method: "POST",
              success: function (info) {
                console.log(info);
              }
            })
          }
        })
      }
    })
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})