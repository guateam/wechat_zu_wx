// pages/welcome/welcome.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    yuming:app.globalData.yuming
  },

  /**
   * 生命周期函数--监听页面加载
   */
  userinfo(e){
    if (e.detail.errMsg == "getUserInfo:fail auth deny"){
      wx.navigateBack({
        delta:-1
      })
    }else{
      getApp().globalData.userinfo = e.detail.userinfo;
      wx.request({
        url: app.globalData.posttp + app.globalData.postdir + "/wechat/php/if_register.php",
        data: {
          openid: app.globalData.openid,
        },
        header: {
          'content-type': 'application/x-www-form-urlencoded'
        },
        method: "POST",
        success: function (result) {
          result = result.data;
          if (result.status == 0) {
            //保存用户信息到数据库
            wx.request({
              url: app.globalData.posttp + app.globalData.postdir + "/wechat/php/upload_customer.php",
              data: {
                openid: app.globalData.openid,
                username: e.detail.userInfo.nickName,
                gender: e.detail.userInfo.gender,
                head: e.detail.userInfo.avatarUrl
              },
              header: {
                'content-type': 'application/x-www-form-urlencoded'
              },
              method: "POST",
              success: function (res) {
                res = res.data;
                wx.switchTab({
                  url: '../index/index'
                })
              }
            })
          }else{
            wx.switchTab({
              url: '../index/index'
            })
          }
        }
      })
    }
    
  },
  
  onLoad: function (options) {
    this.setData({
      yuming:app.globalData.yuming
    })
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