<?php

namespace CuongDev\Larab\Abstraction\Definition;

class Message
{
    const SUCCESS = 'Thao tác thành công!';

    const FAILURE = 'Thao tác thất bại!';

    const SERVER_ERROR = 'Có lỗi xảy ra!';

    const NOT_FOUND = 'Lỗi không tìm thấy!';

    const MISSING_PARAMS = 'Lỗi thiếu tham số truyền vào.';

    const FIND_SUCCESS = 'Lấy dữ liệu thành công!';
    const FIND_FAILURE = 'Lấy dữ liệu thất bại!';

    const CREATE_SUCCESS = 'Tạo mới thành công!';
    const CREATE_FAILURE = 'Tạo mới thất bại!';

    const UPDATE_SUCCESS = 'Cập nhật thành công!';
    const UPDATE_FAILURE = 'Cập nhật thất bại!';

    const DELETE_SUCCESS = 'Xoá thành công!';
    const DELETE_FAILURE = 'Xoá thất bại!';

    /**
     * Http status message
     */
    const HTTP_UNAUTHORIZED = 'Lỗi truy cập không hợp lệ!';
    const HTTP_NOT_FOUND = 'Lỗi url không hợp lệ hoặc không tồn tại!';
    const HTTP_TOKEN_EXPIRED = 'Phiên đăng nhập đã hết hạn!';
}
