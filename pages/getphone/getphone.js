// pages/getphone/getphone.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    options: '',
  },
  phonenum(e) {
    var that = this;
    console.log(e.detail.errMsg)
    console.log(e.detail.iv)
    console.log(e.detail.encryptedData)
    //未授权的情况
    if (e.detail.errMsg != 'getPhoneNumber:ok') {
      wx.showModal({
        title: '提示',
        showCancel: false,
        content: '未授权',
        success: function (res) {

        }
      })
    } else {
      //解密密码
      wx.request({
        url: app.globalData.posttp + app.globalData.postdir + '/wechat/php/phone_decode.php',
        data: {
          appid: app.globalData.appid,
          session_key: app.globalData.session_key,
          encryptedData: e.detail.encryptedData,
          iv: e.detail.iv,
          openid: app.globalData.openid
        },
        header: {
          'content-type': 'application/x-www-form-urlencoded'
        },
        method: "POST",
        success: function (res) {
          res = res.data;
          //成功获取手机号并且存入数据库了
          if (res.status == 1) {
            var phone = res.phone;
            if(that.data.options['phone']==='0'){
              that.data.options['phone'] = res.phone;
            }
            //获取参数并跳转到pay页面
            var url = "../pay/pay?";
            var i = 0;
            for (var key in that.data.options) {
              if (i == 0) {
                url += (key + '=' + that.data.options[key])
                i++;
              } else {
                url += ('&' + key + '=' + that.data.options[key])
              }
            }
            wx.navigateTo({
              url: url,
            })
          }

        }
      })
    }
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this.setData({
      openid: app.globalData.openid,
      postdir: app.globalData.postdir,
      options: options,
    })
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