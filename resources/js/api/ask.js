import request from '@/utils/request';

/**
 * Simple RESTful resource class
 */
class Ask {
  constructor(uri) {
    this.uri = uri;
  }
  list(query, type) {
    return request({
      url: '/' + this.uri + '/' + type,
      method: 'get',
      params: query,
    });
  }
}

export { Ask as default };
