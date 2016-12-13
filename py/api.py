#coding=utf-8

import cv2
import numpy
import argparse

import os
ddir = os.path.split(os.path.realpath(__file__))[0]

IMAGE_URL = './PUBLIC/photos'

def main(filename,args):
	url = ddir+'/'+filename
	image = cv2.imread(url)
	blur = cv2.bilateralFilter(image,args[0],args[1],args[2])
	cv2.imwrite(ddir+"/new.jpg", blur)

def run():

	parser = argparse.ArgumentParser(description='图像处理api')
	parser.add_argument('file', help="输入图片文件名") 
	parser.add_argument('-i', metavar='N', type=int, nargs='+',
	                    help='输入三个参数,滤波领域直径,空间高斯函数标准差,灰度值相似性标准差')
	# 11 51 51
	args = parser.parse_args()
	main(args.file,args.i)

if __name__ == '__main__':
	run()