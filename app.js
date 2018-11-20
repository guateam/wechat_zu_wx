//app.js
App({
  globalData:{
    personInfo:"",
    openid:"",
  },
  onLaunch: function () {
    // 展示本地存储能力
    var that = this;
    var logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)

    // 登录
    wx.login({
      success: res => {
        // 发送 res.code 到后台换取 openId, sessionKey, unionId
        if (res.code) {
          var APPID = 'wxe1e434222057b10e';
          var APPSECRET = 'c5283cabffbbe714ba1c333fcead2487';
          var l = "https://api.weixin.qq.com/sns/jscode2session?appid=" + APPID + "&secret=" + APPSECRET + "&js_code=" + res.code + "&grant_type=authorization_code";
          wx.request({
            url: l,
            data: {},
            header: {
              'content-type': 'application/json'
            },
            success: function (res) {
              var opid = res.data.openid //返回openid
              that.globalData.openid = opid;
               wx.getUserInfo({
                success: function (res) {
                  that.globalData.personInfo = res.userInfo;
                  wx.request({
                    url: "http://172.20.10.3/wechat/php/if_register.php",
                    data: {
                      openid: opid,
                    },
                    header: {
                      'content-type': 'application/x-www-form-urlencoded'
                    },
                    method: "POST",
                    success: function (result) {
                      result = result.data;
                      if(result.status == 0){
                        //保存用户信息到数据库
                        wx.request({
                          url: "http://172.20.10.3/wechat/php/upload_customer.php",
                          data: {
                            openid: opid,
                            username: res.userInfo.nickName,
                            gender: res.userInfo.gender,
                            head: res.userInfo.avatarUrl
                          },
                          header: {
                            'content-type': 'application/x-www-form-urlencoded'
                          },
                          method: "POST",
                          success: function (res) {
                            res = res.data;
                          }
                        })
                      }
                    }
                  })
                }
              })
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