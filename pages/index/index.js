//index.js
//获取应用实例
const app = getApp()
var sliderWidth = 144 // 需要设置slider的宽度，用于计算中间位置
Page({
  data: {
    loading:false,
    yuming: 'http://a.lobopay.cn', //图片的域名
    x: 300,
    y: 450,
    userInfo: "",
    top_pic: [],
    items1: {},
    items2: {},
    openid: '',
    data: {},
    value2: 0,
    animate: false,
    items3: [],
    current: '1',
    tab1: true,
    tabs: ["项目分类", "优惠活动"],
    activeIndex: 0,
    sliderOffset: 0,
    sliderLeft: 0
  },
  onShareAppMessage: function (res) {
    if (res.from === 'button') {
      // 来自页面内转发按钮
      console.log(res.target)
    }
    return {
      title: '御足堂影院式足道',
      path: '/page/index/index',
      success: function (res) {
        // 转发成功
      },
      fail: function (res) {
        // 转发失败
      }
    }
  },
  handleChange({
    detail
  }) {
    var index = detail.key
    console.log(index)
    this.setData({
      current: detail.key
    });
    if (index == 1) {
      this.setData({
        tab1: true,
        tab2: false
      })
    } else if (index == 2) {
      this.setData({
        tab1: false,
        tab2: true
      })
    }
  },
  tap: function (e) {
    this.setData({
      x: 30,
      y: 30
    });
  },
  handleChangeScroll({
    detail
  }) {
    this.setData({
      current_scroll: detail.key
    });
  },
  //事件处理函数
  openmap: function () {
    var that = this
    wx.getLocation({
      type: 'gcj02', //返回可以用于wx.openLocation的经纬度
      success(res) {
        const latitude = res.latitude
        const longitude = res.longitude
        wx.openLocation({
          latitude: 30.3036750000,
          longitude: 120.3032260000,
          scale: 18,
          name: that.data.data.name,
          address: that.data.data.position
        })

      }
    })
  },
  phone: function () {
    wx.makePhoneCall({
      phoneNumber: this.data.data.phone,
    })
  },
  tea: function () {
    wx.navigateTo({
      url: '../tea/tea'
    })
  },
  head_to: function (e) {
    var link = e.currentTarget.dataset.link;
    var arg = link.split('?');
    wx.navigateTo({
      url: '../many/many?link=' + arg[0] + '&' + arg[1]
    })
  },
  jishiyuyue: function () {
    wx.navigateTo({
      url: '../jishiyuyue/jishiyuyue'
    })
  },
  culture: function () {
    wx.navigateTo({
      url: '../culture/culture',
    })
  },
  stopTouchMove: function () {
    return false;
  },
  recharge: function () {
    wx.navigateTo({
      url: '../recharge/recharge?openid=' + app.globalData.openid,
    })
  },
  dashangjishi: function () {
    wx.navigateTo({
      url: '../dashangjishi/dashangjishi?openid=' + app.globalData.openid,
    })
  },
  onLoad: function () {
    var that = this;
    this.setData({
      postdir:app.globalData.postdir
    })
    var id = '1'
    var back = {};
    wx.getSystemInfo({
      success: function (res) {
        that.setData({
          sliderLeft: (res.windowWidth / that.data.tabs.length - sliderWidth) / 2,
          sliderOffset: res.windowWidth / that.data.tabs.length * that.data.activeIndex
        });
      }
    });
    if (app.globalData.userInfo) {
      this.setData({
        userInfo: app.globalData.userInfo,
        hasUserInfo: true
      })
    } else if (this.data.canIUse) {
      // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
      // 所以此处加入 callback 以防止这种情况
      app.userInfoReadyCallback = res => {
        this.setData({
          userInfo: res.userInfo,
          hasUserInfo: true
        })
      }
    } else {
      // 在没有 open-type=getUserInfo 版本的兼容处理
      wx.getUserInfo({
        success: res => {
          app.globalData.userInfo = res.userInfo
          this.setData({
            userInfo: res.userInfo,
            hasUserInfo: true
          })
        }
      })
    }
    wx.request({
      method: 'POST',
      data: {
        id: id
      },
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      url: app.globalData.posttp+app.globalData.postdir+'/wechat/php/getmainpage.php',
      success: function (data) {
        data = data.data;
        if (data.status == 1) {
          that.setData({
            top_pic: data.top_pic,
          })
          back = data.data
          console.log(back)
          console.log(that.data.data.userInfo);
        }
        if (back.app1.status == 1) {
          that.setData({
            items1: back.app1.data
          })

        }
        if (back.app2.status == 1) {
          that.setData({
            items2: back.app2.data
          })
        }
        if (back.notice.status == 1) {
          that.setData({
            items3: back.notice.data
          })

        }
        if (back.shop.status == 1) {
          that.setData({
            data: back.shop.data
          })
        }
      }
    })
  },
  tabClick: function (e) {
    this.setData({
      sliderOffset: e.currentTarget.offsetLeft,
      activeIndex: e.currentTarget.id
    });
  },
  swipclick: function (e) {
    //点击图片触发事件
    console.log(this.data.imageUrls[this.data.current]);
  }
  // getUserInfo: function(e) {
  //   console.log(e)
  //   app.globalData.userInfo = e.detail.userInfo
  //   this.setData({
  //     userInfo: e.detail.userInfo,
  //     hasUserInfo: true
  //   })
  // }
})