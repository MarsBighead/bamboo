#encoding: utf-8
from reportlab.pdfgen import canvas

def hello(c):
	c.drawString(100, 100, "Hello world!")
	c.drawString(0,10, "Y")
	c.drawString(0, 100, "0.100")
	c.drawString(10, 0,"X")
	c.drawString(590, 0,"*")
	c.drawString(0, 837,"$")

c = canvas.Canvas("hello.pdf")
hello(c)
c.showPage()
hello(c)
c.showPage()
c.save()
