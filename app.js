//app.js
App({
  globalData: {
    postdir:'172.20.10.3',
    //postdir: 'a.lobopay.cn',
    //postdir: 'yzt.wangjiyu.cn',
    posttp:"http://",
    //posttp: "https://",
    personInfo: "",
    openid: "",
    userinfo_success: "",
    appid: "wxe1e434222057b10e",
    appsecret: "c5283cabffbbe714ba1c333fcead2487",
    //yuming: 'http://a.lobopay.cn', //图片的域名
    yuming: 'https://yzt.wangjiyu.cn', //图片的域名
  },
  onLaunch: function () {
    // 展示本地存储能力
    var that = this;
    var logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)

    // 登录
    wx.login({
      complete: res => {
        // 发送 res.code 到后台换取 openId, sessionKey, unionId
        if (res.code) {
          var APPID = 'wxe1e434222057b10e';
          var APPSECRET = 'c5283cabffbbe714ba1c333fcead2487';
          var getopenid_url = "https://api.weixin.qq.com/sns/jscode2session?appid=" + APPID + "&secret=" + APPSECRET + "&js_code=" + res.code + "&grant_type=authorization_code";
          wx.request({
            method: "POST",
            url: that.globalData.posttp + that.globalData.postdir + "/wechat/php/get_openid.php",
            data: {
              code: res.code
            },
            header: {
              'content-type': 'application/x-www-form-urlencoded'
            },
            complete: function (res) {
              var opid = res.data.openid //返回openid
              that.globalData.openid = opid;
              that.globalData.session_key = res.data.session_key
            }
          })
        } else {
          console.log('获取用户登录态失败！' + res.errMsg)
        }
      }
    })
    // 获取用户信息
    // wx.getSetting({
    //   success: res => {
    //     if (res.authSetting['scope.userInfo']) {
    //       // 已经授权，可以直接调用 getUserInfo 获取头像昵称，不会弹框
    //       wx.getUserInfo({
    //         success: res => {
    //           // 可以将 res 发送给后台解码出 unionId
    //           this.globalData.userInfo = res.userInfo

    //           // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
    //           // 所以此处加入 callback 以防止这种情况
    //           if (this.userInfoReadyCallback) {
    //             this.userInfoReadyCallback(res)
    //           }
    //         }
    //       })
    //     }
    //   }
    // })
  },
})